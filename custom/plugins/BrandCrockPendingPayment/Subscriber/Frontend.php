<?php
/**
 * The Frontend file
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
namespace BrandCrockPendingPayment\Subscriber;

use Enlight\Event\SubscriberInterface;

class Frontend implements SubscriberInterface
{
    /**
     * To get the subscriber event
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Modules_Order_SaveOrder_FilterAttributes' => 'onOrderFilterSave',
        ];
    }
    /**
     * To update the order attributes/ insert the bc order
     *
     * @return array
     */
    public function onOrderFilterSave(\Enlight_Event_EventArgs $args)
    {
        $view     = $args->get('orderParams');
        $orderID     = $args->get('orderID');
        $paymenttype = $view['paymentID'];
        $ordernumber = $view['ordernumber'];
        $shippedtime = 1;
        $orderDueDate = Shopware()->Db()->fetchOne("SELECT bc_payment_due_date FROM `s_core_paymentmeans_attributes` where paymentmeanID = '$paymenttype'");
        $orderDueDate = ($orderDueDate) ? $orderDueDate : 10;
        $duedate =  date('Y-m-d', strtotime(date('Y-m-d H:i:s'). ' + '. $orderDueDate .' days'));
        $sUserData = Shopware()->Session()->sOrderVariables['sUserData'];
        $paymentName = $sUserData['additional']['payment']['name'];
        $tableValues = [
                'payment_type' =>$paymenttype,
                'ordernumber'=> $ordernumber,
                'overdue_date' => $duedate,
                'ordered_date' => date('Y-m-d H:i:s'),
                'shipped_date' => $shippedtime,
                'paymentname' => $paymentName,
                'overdue' => 0,
                'orderID' => $orderID,
        ];
        Shopware()->Db()->insert('bc_order_filter', $tableValues);
        return ['bc_due_date' => $duedate];
    }
}
