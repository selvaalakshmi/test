<?php
/**
 * Plugin file (Bootstrap)
 *
 * Copyright (C) BrandCrock GmbH. All rights reserved
 *
 * If you have found this script useful a small
 * recommendation as well as a comment on our
 * home page(https://brandcrock.com/)
 * would be greatly appreciated.
 *
 * @author       BrandCrock
 * @package      BrandCrockPendingPayment
 */

use BrandCrockPendingPayment\Models\Product;
use Shopware\Components\CSRFWhitelistAware;

class Shopware_Controllers_Backend_BrandCrockPendingPayment extends Shopware_Controllers_Backend_Application implements CSRFWhitelistAware
{
    protected $model = Product::class;
    protected $alias = 'product';
    /**
     * To get array for csrf
     *
     * @return array
     */
    public function getWhitelistedCSRFActions()
    {
        return [
            'list',
        ];
    }
    /**
     * To list the orders
     *
     * @return null
     */
    public function listAction()
    {
        $format = $this->Request()->getParam('format');
        $session = Shopware()->BackendSession();
        $filter = $this->Request()->getParam('filter', []);
        $start = $this->Request()->getParam('start');
        $limit =$this->Request()->getParam('limit');
        $sort = $this->Request()->getParam('sort', []);
        $repository = Shopware()->Models()->getRepository(\Shopware\Models\Shop\Currency::class);

        $builder = $repository->createQueryBuilder('c');
        $builder->select([
            'c.id as id',
            'c.name as name',
            'c.currency as currency',
            'c.symbol as symbol',
        ]);
        $query = $builder->getQuery();
        $curency = $query->getArrayResult();
        if (!$filter) {
            $repository = Shopware()->Models()->getRepository(\Shopware\Models\Order\Order::class);
            $builder = $repository->getOrdersQueryBuilder($filters, $orderBy);
            if ($limit !== null) {
                $builder->setFirstResult($start)
                ->setMaxResults($limit);
            }
            $paginator = $this->getQueryPaginator($builder);
            $data = $paginator->getIterator()->getArrayCopy();
            $count = $paginator->count();
            $namespace = $this->get('snippets')
            ->getNamespace('backend/brand_crock_pending_payment/view/main');
            $bcno = $namespace->get('bcno', 'No');
            $bcyes = $namespace->get('bcyes', 'Yes');
            foreach ($data as $k => $values) {
                $datas[$k]['id'] =$values['id'];
                $datas[$k]['documentDate'] ='';
                $datas[$k]['number'] = $values['number'];
                $now = $values['orderTime'];
                $datas[$k]['invoiceAmount'] = $values['invoiceAmount'] .' ' . html_entity_decode($curency[0]['symbol'], ENT_HTML5, 'utf-8') ;
                $dataInvoiceAmt[] = $values['invoiceAmount'];
                $datas[$k]['invoiceAmountNet'] = $values['invoiceAmountNet'] .' ' . html_entity_decode($curency[0]['symbol'], ENT_HTML5, 'utf-8') ;
                $datasNet[] = $values['invoiceAmountNet'];
                $datas[$k]['orderTime'] = $now->format('Y-m-d');
                $datas[$k]['customerComment'] = $values['customerComment'];
                $datas[$k]['customerFirstName'] = $values['billing']['firstName'];
                $datas[$k]['customerLastName'] = $values['billing']['lastName'];
                $datas[$k]['company'] = $values['billing']['company'];
                $datas[$k]['payment'] = $values['payment']['name'];
                $datas[$k]['invoiceNumber'] ='';


                if ($values['documents']) {
                    foreach ($values['documents'] as $kee => $value) {
                        if ($value['type']['key'] =='invoice') {
                            $datas[$k]['invoiceNumber'] =  $value['documentId'];
                            $nows = $value['date'];
                            $datas[$k]['documentDate'] =  $nows->format('Y-m-d');
                        }
                    }
                }
                $orderID = $data[$k]['id'];
                $bcDate = Shopware()->Db()->fetchRow("SELECT bc_due_date, bc_over_due FROM s_order_attributes where orderID = '$orderID'");
                $bcDueDate = $bcDate['bc_due_date'];
                $bcOverDue = $values['clearedDate'];
                $dateTimestamp1 = strtotime($bcDueDate);
                $dateTimestamp2 = strtotime($bcOverDue);
                if (empty($bcOverDue) || $bcOverDue == null) {
                    $datas[$k]['overdue'] = $bcno;
                } elseif ($dateTimestamp1 > $dateTimestamp2) {
                    $datas[$k]['overdue'] = $bcno;
                } else {
                    $datas[$k]['overdue'] =  $bcyes;
                }
                $bcPaidAmountcurrency = ($values['attribute']['bcPaidAmount']) ? html_entity_decode($curency[0]['symbol'], ENT_HTML5, 'utf-8')  : '';
                $bcPendingAmountcurrency = ($values['attribute']['bcPendingAmount']) ? html_entity_decode($curency[0]['symbol'], ENT_HTML5, 'utf-8')  : '';
                $datas[$k]['bcPaidAmount'] = $values['attribute']['bcPaidAmount'] .' ' .$bcPaidAmountcurrency ;
                $datas[$k]['bcPendingAmount'] = $values['attribute']['bcPendingAmount'] .' ' .$bcPendingAmountcurrency ;
                $datas[$k]['customerReferenceNumber'] = $values['attribute']['customerReferenceNumber'];
            }

            $bcTotalAmount = $namespace->get('bcTotalAmount', 'Total');
            $bcinvoiceAmount = $namespace->get('bcinvoiceAmount', 'Invoice Amount');
            $bcinvoiceAmountNet = $namespace->get('bcinvoiceAmountNet', 'Invoice AmountNet');

            $datas[count($data)]['bcPendingAmount'] = $bcTotalAmount . ' ' . $bcinvoiceAmount;
            $datas[count($data)]['customerReferenceNumber'] = $bcTotalAmount . ' ' . $bcinvoiceAmountNet;
            $datas[count($data)+1]['bcPendingAmount'] = array_sum($dataInvoiceAmt) .' ' . html_entity_decode($curency[0]['symbol'], ENT_HTML5, 'utf-8') ;
            $datas[count($data)+1]['customerReferenceNumber'] = array_sum($datasNet) .' ' . html_entity_decode($curency[0]['symbol'], ENT_HTML5, 'utf-8') ;
        } else {
            $where_append = "";
            if (!empty($filter)) {
                foreach ($filter as $k => $v) {
                    if ($v['property'] == 'number') {
                        $v['property'] = 'ord.ordernumber';
                        $value_data = "'%".$v['value']."%'";
                        $equal_in = 'like';
                    }
                    if ($v['property'] == 'bcPaidAmount') {
                        $v['property'] = 'pay.bc_paid_amount';
                        $value_data = "'".$v['value']."'";
                        $equal_in = '=';
                    }
                    if ($v['property'] == 'bcPendingAmount') {
                        $v['property'] = 'pay.bc_pending_amount';
                        $value_data = "'".$v['value']."'";
                        $equal_in = '=';
                    }
                    if ($v['property'] == 'customerReferenceNumber') {
                        $v['property'] = 'pay.customer_reference_number';
                        $value_data = "'%".$v['value']."%'";
                        $equal_in = 'like';
                    }
                    if ($v['property'] == 'invoiceAmount') {
                        $v['property'] = 'ord.invoice_amount';
                        $value_data = "'".$v['value']."'";
                        $equal_in = '=';
                    }
                    if ($v['property'] == 'invoiceAmountNet') {
                        $v['property'] = 'ord.invoice_amount_net';
                        $value_data = "'".$v['value']."'";
                        $equal_in = '=';
                    }
                    if ($v['property'] == 'customerComment') {
                        $v['property'] = 'ord.customercomment';
                        $value_data = "'%".$v['value']."%'";
                        $equal_in = 'like';
                    }
                    if ($v['property'] == 'customerFirstName') {
                        $v['property'] = 'billing.firstname';
                        $value_data = "'%".$v['value']."%'";
                        $equal_in = 'like';
                    }
                    if ($v['property'] == 'customerLastName') {
                        $v['property'] = 'billing.lastname';
                        $value_data = "'%".$v['value']."%'";
                        $equal_in = 'like';
                    }
                    if ($v['property'] == 'company') {
                        $v['property'] = 'billing.company';
                        $value_data = "'%".$v['value']."%'";
                        $equal_in = 'like';
                    }
                    if ($v['property'] == 'invoiceNumber') {
                        $v['property'] = 'doc.docID';
                        $value_data = "'".$v['value']."'";
                        $equal_in = '=';
                    }
                    if ($v['property'] == 'payment') {
                        $v['property'] = 'ord.paymentID';
                        $value_data = "'".$v['value']."'";
                        $equal_in = '=';
                    }
                    if ($v['property'] == 'overdue') {
                        $v['property'] = 'bc.overdue';
                        $value_data = "'".$v['value']."'";
                        $equal_in = '=';
                    }

                    if ($k == 0) {
                        $condition = "";
                    } else {
                        $condition = "OR";
                    }
                    if (is_array($v['value'])) {
                        $val = implode(",", $v['value']);
                        $value_data = "(".$val.")";
                        $equal_in = 'in';
                    }
                    if ($v['property'] == 'documentDate') {
                        $v['property'] = 'doc.date';

                        $value_data = "'%".$v['value']."%'";
                        $equal_in = 'like';
                    }

                    if ($v['property'] == 'orderTime') {
                        $v['property'] = 'ord.ordertime';

                        $value_data = "'%".$v['value']."%'";
                        $equal_in = 'like';
                    }
                    $where_append.= " ".$condition." ".$v['property'] ." ".$equal_in ." ".  $value_data;
                    if ($v['property'] == 'search') {
                        $wheresearch[0] = 'ord.ordertime';
                        $wheresearch[1] = 'doc.date';
                        $wheresearch[2] = 'bc.overdue_date';
                        $wheresearch[3] = 'ord.paymentID';
                        $wheresearch[4] = 'doc.docID';
                        $wheresearch[5] = 'billing.firstname';
                        $wheresearch[6] = 'billing.lastname';
                        $wheresearch[7] = 'ord.customercomment';
                        $wheresearch[8] =  'ord.invoice_amount_net';
                        $wheresearch[9] =  'ord.invoice_amount';
                        $wheresearch[10] = 'ord.ordernumber';
                        $wheresearch[11] = 'bc.overdue';
                        $wheresearch[12] = 'pa.bc_paid_amount';
                        $wheresearch[13] = 'pa.bc_pending_amount';
                        $wheresearch[14] = 'pa.customer_reference_number';
                        $where_append ='';
                        $s = 1;
                        $where_append = '';
                        foreach ($wheresearch as $k => $val) {
                            $where_append .= $val . " like '%".$v['value']."%'";
                            $where_append .= ($k != 14) ? " or " : '';
                        }
                    }
                }

                $sResultData = '';
                $sqlQuery = "SELECT
                DISTINCT(ord.id),
                billing.company,
                billing.firstname,
                billing.lastname,
                doc.docID,
                doc.date,
                ord.id,
                ord.ordernumber,
                ord.currency,
                ord.invoice_amount,
                ord.invoice_amount_net,
                ord.ordertime,
                ord.customercomment,
                ord.paymentID,pa.bc_paid_amount,pa.bc_pending_amount,pa.customer_reference_number,
                bc.overdue
                FROM s_order as ord
                LEFT JOIN s_order_billingaddress as billing ON billing.orderID = ord.id
                LEFT JOIN s_core_paymentmeans as pay ON pay.id = ord.paymentID
                LEFT JOIN s_order_documents as doc ON doc.orderID = ord.id
                LEFT JOIN bc_order_filter as bc ON bc.ordernumber = ord.ordernumber
                LEFT JOIN s_order_attributes as pa ON pa.orderID = ord.id
                where $where_append";
                $start = $this->Request()->getParam('start');
                $limit =$this->Request()->getParam('limit');
                $sort = $this->Request()->getParam('sort', []);
                $sResultData = Shopware()->Db()->fetchAll($sqlQuery);
                $count = count($sResultData);
                if (!empty($limit)) {
                    $sqlQuery .= " Limit " . $start . "," . $limit;
                }
                $sResultData = Shopware()->Db()->fetchAll($sqlQuery);
                $totalCount = count($sResultData);
                $namespace = $this->get('snippets')
                ->getNamespace('backend/brand_crock_pending_payment/view/main');
                $bcno = $namespace->get('bcno', 'No');
                $bcyes = $namespace->get('bcyes', 'Yes');
                foreach ($sResultData as $key => $values) {
					$datas[$key]['id'] =$values['id'];
                    $datas[$key]['documentDate'] = $values['date'];
                    $datas[$key]['number'] = $values['ordernumber'];
                    $datas[$key]['invoiceAmount'] = $values['invoice_amount'] .' ' . html_entity_decode($curency[0]['symbol'], ENT_HTML5, 'utf-8') ;
                    $datas[$key]['invoiceAmountNet'] = $values['invoice_amount_net'] .' ' .html_entity_decode($curency[0]['symbol'], ENT_HTML5, 'utf-8') ;
                    $datas[$key]['orderTime'] = $values['ordertime'];
                    $datas[$key]['customerComment'] = $values['customercomment'];
                    $dataInvoiceAmt[] = $values['invoice_amount'];
                    $datasNet[] = $values['invoice_amount_net'];
                    $datas[$key]['customerFirstName'] = $values['firstname'];
                    $datas[$key]['customerLastName'] = $values['lastname'];
                    $datas[$key]['company'] = $values['company'];
                    if ($datas[$key]['payment'] = $values['paymentID']) {
                        $idP = $values['paymentID'];
                        $pay_name = "select name from s_core_paymentmeans where id ='$idP'";
                        $pay_name_res = Shopware()->Db()->fetchAll($pay_name);
                    }
                    $datas[$key]['payment'] = $pay_name_res[0]['name'];
                    $datas[$key]['invoiceNumber'] = $values['docID'];
                    $datas[$key]['overdue'] = ($values['overdue'] == '1') ? $bcno : $bcyes;
                    $bc_paid_amount = ($values['bc_paid_amount']) ?  html_entity_decode($curency[0]['symbol'], ENT_HTML5, 'utf-8')  : '';
                    $bc_pending_amount = ($values['bc_pending_amount']) ? html_entity_decode($curency[0]['symbol'], ENT_HTML5, 'utf-8')  : '';
                    $datas[$key]['bcPaidAmount'] = $values['bc_paid_amount'] .' ' . $bc_paid_amount;
                    $datas[$key]['bcPendingAmount'] = $values['bc_pending_amount'] .' ' . $bc_pending_amount;
                    $datas[$key]['customerReferenceNumber'] = $values['customer_reference_number'];
                }
                if ($totalCount != 0) {
                    $bcTotalAmount = $namespace->get('bcTotalAmount', 'Total');
                    $bcinvoiceAmount = $namespace->get('bcinvoiceAmount', 'Invoice Amount');
                    $bcinvoiceAmountNet = $namespace->get('bcinvoiceAmountNet', 'Invoice AmountNet');
                    $totalCount = ($totalCount == 1) ? $totalCount : $totalCount;
                    $datas[$totalCount]['bcPendingAmount'] = $bcTotalAmount . ' ' .$bcinvoiceAmount;
                    $datas[$totalCount]['customerReferenceNumber'] = $bcTotalAmount .' ' . $bcinvoiceAmountNet;
                    $datas[$totalCount+1]['bcPendingAmount'] = array_sum($dataInvoiceAmt) .' ' . html_entity_decode($curency[0]['symbol'], ENT_HTML5, 'utf-8') ;
                    $datas[$totalCount+1]['customerReferenceNumber'] = array_sum($datasNet) .' ' . html_entity_decode($curency[0]['symbol'], ENT_HTML5, 'utf-8') ;
                }
            }
        }
        if ($format) {
            if ($session->bcLoadedData) {
                $datass = $session->bcLoadedData;
            }
            $this->exportCSV($datass);
        } else {
            $session->bcLoadedData = $datas;
            $this->View()->assign(['success'=> true,'data' => $datas ,'total' => $count]);
        }
    }
    /**
     * To export the csv file
     *
     * @params array $data
     *
     * @return null
     */
    protected function exportCSV($data)
    {
        $this->Front()->Plugins()->Json()->setRenderer(false);
        $this->Response()->setHeader('Content-Type', 'text/csv; charset=utf-8');
        $this->Response()->setHeader('Content-Disposition', 'attachment;filename=' . 'export-oposlist-'. date('Y-m-d').'.csv');
        $namespace = $this->get('snippets')
            ->getNamespace('backend/brand_crock_pending_payment/view/main');

        $bcdocumentDate = $namespace->get('bcdocumentDate', 'Document Date');
        $bcordernumber = $namespace->get('bcordernumber', 'Order Number');
        $bcinvoiceAmount = $namespace->get('bcinvoiceAmount', 'Invoice Amount');
        $bcinvoiceAmountNet = $namespace->get('bcinvoiceAmountNet', 'Invoice AmountNet');
        $bcordertime = $namespace->get('bcordertime', 'Order Time');
        $bccustomercomment = $namespace->get('bccustomercomment', 'Customer Comment');
        $bccustomerfirstname = $namespace->get('bccustomerfirstname', 'Customer FirstName');
        $bccustomerlastname = $namespace->get('bccustomerlastname', 'Customer LastName');
        $bccompany = $namespace->get('bccompany', 'Company');
        $bcinvoicenumber = $namespace->get('bcinvoicenumber', 'Invoice Number');
        $bcpaymenttypes = $namespace->get('bcpaymenttypes', 'Payment Types');
        $bcoverdue = $namespace->get('bcoverdue', 'Overdue');
        $bcno = $namespace->get('bcno', 'No');
        $bcyes = $namespace->get('bcyes', 'Yes');
        $bcpaidamount = $namespace->get('bcpaidamount', 'Payment Made');
        $bcPendingAmount = $namespace->get('bcPendingAmount', 'Payment Expected');
        $bccustomerReferenceNumber = $namespace->get('bccustomerReferenceNumber', 'Reference Number');
        $csvcolumns =
        [
            'documentDate'                              => $bcdocumentDate,
            'number'                                    => $bcordernumber,
            'invoiceAmount'                             => $bcinvoiceAmount,
            'invoiceAmountNet'                          => $bcinvoiceAmountNet,
            'orderTime'                                 => $bcordertime,
            'customerComment'                           => $bccustomercomment,
            'customerFirstName'                         => $bccustomerfirstname,
            'customerLastName'                          => $bccustomerlastname,
            'company'                                   => $bccompany,
            'payment'                                   => $bcpaymenttypes,
            'invoiceNumber'                             => $bcinvoicenumber,
            'overdue'                                   => $bcoverdue,
            'bcpaidamount'                              => $bcpaidamount,
            'bcPendingAmount'                           => $bcPendingAmount,
            'bccustomerReferenceNumber'                 => $bccustomerReferenceNumber,
        ];
        echo "\xEF\xBB\xBF";
        $fp = fopen('php://output', 'w');
        fputcsv($fp, array_values($csvcolumns), ';');
        foreach ($data as $k =>  $line) {
			if($line['id']) {
				unset($line['id']);
				}            fputcsv($fp, $line, ';');
        }
        fclose($fp);
    }
}
