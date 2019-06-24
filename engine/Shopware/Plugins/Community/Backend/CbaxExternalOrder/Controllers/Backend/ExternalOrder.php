<?php
class Shopware_Controllers_Backend_ExternalOrder extends Shopware_Controllers_Backend_ExtJs
{
	private $plugin;
	
    private $config;
	
	private $externalOrderDb;
	
	public function init()
	{
		$this->externalOrderDb 		= Shopware()->ExternalOrderDb();
		$this->plugin 				= Shopware()->Plugins()->Backend()->CbaxExternalOrder();
        $this->config 				= $this->plugin->Config();
		
		$this->View()->addTemplateDir(dirname(__FILE__) . "/../../Views/");
        parent::init();
	}
	
	public function initAcl()
    {
        $this->addAclPermission('getExternalOrders', 'read', 'Ops. Read access denied.');
		$this->addAclPermission('updateCustomer', 'update', 'Ops. Update access denied.');
		$this->addAclPermission('generateShopwareOrder', 'generate', 'Ops. Gererate access denied.');
		$this->addAclPermission('deleteExternalOrder', 'delete', 'Ops. Delete access denied.');
    }

	public function indexAction()
	{
		$this->View()->loadTemplate("backend/external_order/app.js");
	}
	
	public function getExternalOrdersAction()
	{
		$request = $this->Request();
		
		$limit = intval($request->getParam('limit',25));
		$start = intval($request->getParam('start',0));

		$sort = $request->getParam('sort');
		$property = $sort[0]["property"];
		$direction = $sort[0]["direction"];
		if (empty($property)) $property = "created";
        if (empty($direction)) $direction = "DESC";
		
		$startDate	= $request->getParam('fromDate','');
		$endDate   	= $request->getParam('toDate','');
		
		$account	= trim($request->getParam('account', -1));
		$payment	= trim($request->getParam('payment', -1));
		$status		= trim($request->getParam('status', -1));
		$generate	= trim($request->getParam('generate', ''));
		$shipped	= trim($request->getParam('shipped', ''));
		$searcharticle	= trim($request->getParam('searcharticle', ''));
		
		$filterSql = "WHERE 1 = 1";
		if ($startDate)
		{
			$filterSql .= " AND DATE (o.created) >= '$startDate'";
		}
		
		if ($endDate)
		{
			$filterSql .= " AND DATE (o.created) <= '$endDate'";
		}
		
		
		if ((strlen($account) > 0) && ($account != '-1'))
		{
			$filterSql .= " AND o.account = '".trim($account)."'";
		}
		
		if ((strlen(trim($payment)) > 0)  && (intval($payment) != -1))
		{
			$filterSql .= " AND o.paymentID = '$payment'";
		}
		
		if ((strlen(trim($status)) > 0)  && (intval($status) != -1))
		{
			$filterSql .= " AND ord.status = '$status'";
		}
		
		if (!empty($generate))
		{
			if ($generate == 1)
			{
				$filterSql .= " AND o.orderID IS NOT NULL";
			}
			else
			{
				$filterSql .= " AND o.orderID IS NULL";
			}
		}
		
		if (!empty($shipped))
		{
			if ($shipped == 1)
			{
				$filterSql .= " AND o.shipped_to_account = '2'";
			}
			elseif ($shipped == 3)
			{
				$filterSql .= " AND o.shipped_to_account = '3'";
			}
			else
			{
				$filterSql .= " AND o.shipped_to_account < '2'";
			}
		}
		
		$filterParams = $this->Request()->getParam('filter', array());
		$filters = array();
        foreach ($filterParams as $singleFilter)
		{
			$filters[$singleFilter['property']] = $singleFilter['value'];
		}
		
		if (isset($filters['search']))
		{
			$search = Shopware()->Db()->quote( '%' . trim($filters['search']) . '%' );
			
			$filterSql .= "
			AND (
				o.external_order_number LIKE " . $search . "
			OR
				o.ordernumber LIKE " . $search . "
			OR
				o.customercomment LIKE " . $search . "
			OR
				o.internalcomment LIKE " . $search . "
			OR
				o.transactionID LIKE " . $search . "
			OR
				o.trackingcode LIKE " . $search . "
			OR
				b.company LIKE " . $search . "
			OR
				b.firstname LIKE " . $search . "
			OR
				b.lastname LIKE " . $search . "
			OR
				b.email LIKE " . $search . "
			OR
				s.company LIKE " . $search . "
			OR
				s.firstname LIKE " . $search . "
			OR
				s.lastname LIKE " . $search . "
			)";
		}
		
		if (!empty($searcharticle))
		{
			$searcharticle = "%".$searcharticle."%";
			$filterSql .= " AND od.name LIKE '$searcharticle'";
		}

		$sql = "
		SELECT SQL_CALC_FOUND_ROWS o.id,
			o.id AS id,
			IFNULL(eoa.name,o.account) AS account,
			o.created AS created,
			o.external_order_number AS external_order_number,
			o.invoice_amount AS invoice_amount,
			cp.description AS payment,
			o.orderID AS orderID,
			o.ordernumber AS ordernumber,
			o.orderID AS orderID,
			o.shipped_to_account AS shipped_to_account,
			b.company AS b_company,
			b.salutation AS b_salutation,
			b.firstname AS b_firstname,
			b.lastname AS b_lastname,
			b.street AS b_street,
			b.streetnumber AS b_streetnumber,
			b.zipcode AS b_zipcode,
			b.city AS b_city,
			cs.id AS orderStatus
		FROM
			s_plugin_externalorder_order AS o
			
		LEFT JOIN 
			s_plugin_externalorder_order_details AS od
			ON od.importOrderID = o.id
		
		LEFT JOIN 
			s_plugin_externalorder_order_billingaddress AS b
			ON b.importOrderID = o.id
		
		LEFT JOIN 
			s_plugin_externalorder_order_shippingaddress AS s
			ON s.importOrderID = o.id
		
		LEFT JOIN 
			s_order AS ord
			ON ord.id = o.orderID
		
		LEFT JOIN 
			s_core_states AS cs
			ON cs.id = ord.status
		
		LEFT JOIN
			s_plugin_externalorder_account AS eoa
			ON eoa.name = o.account
			
		LEFT JOIN
			s_core_paymentmeans AS cp
			ON cp.id = o.paymentID
			
		$filterSql
		
		GROUP BY o.id
		ORDER BY {$property} {$direction}
		LIMIT {$start},{$limit}
		";
		
		$orders = Shopware()->Db()->fetchAll($sql);
		
		$sqlCount= "SELECT FOUND_ROWS()";
		$count = Shopware()->Db()->fetchOne($sqlCount);

		foreach ($orders as $key => $value)
		{
			if ($orders[$key]["b_company"])
				$orders[$key]["customer_name"] = trim($orders[$key]["b_company"]);
			else
				$orders[$key]["customer_name"] = trim($orders[$key]["b_firstname"].' '.$orders[$key]["b_lastname"]);
				
			$orders[$key]["created"] = $this->DateTimeFromDb($orders[$key]["created"]);
		}
		
		$this->View()->assign(array("success"=>true, "data"=>$orders, "total"=>$count));
	}
	
	public function getStatisticAction()
    {
        $sql = "
		SELECT 
			IFNULL(eoa.description,o.account) AS account,
			SUM(o.invoice_amount / o.currency_factor)  AS value
        FROM 
			s_plugin_externalorder_order AS o
			
		LEFT JOIN
			s_plugin_externalorder_account AS eoa
			ON eoa.name = o.account
			
        GROUP BY o.account
		ORDER BY value DESC
		";

        $orders = Shopware()->Db()->fetchAll($sql);
		
        $this->View()->assign(array('success'=>true, 'data'=>$orders));
    }

	public function deleteExternalOrderAction()
	{
		$request = $this->request();
		$orderID = $request->id;
		
		if (empty($orderID))
		{
			$this->View()->assign(array("success"=>false));
			return;
		}
		
		Shopware()->Db()->query("DELETE FROM s_plugin_externalorder_order WHERE id = ?", array($orderID));
		Shopware()->Db()->query("DELETE FROM s_plugin_externalorder_order_billingaddress WHERE importOrderID = ?", array($orderID));
		Shopware()->Db()->query("DELETE FROM s_plugin_externalorder_order_details WHERE importOrderID = ?", array($orderID));
		Shopware()->Db()->query("DELETE FROM s_plugin_externalorder_order_shippingaddress WHERE importOrderID = ?", array($orderID));
		
		$this->View()->assign(array("success"=>true));
	}

	public function getCustomerAction()
	{
		$request = $this->request();
		$orderID = $request->id;

		$sql = "
		SELECT
			o.id AS id,
			IFNULL(eoa.description,o.account) AS account,
  			o.external_order_number AS external_order_number,
			DATE_FORMAT(o.created,'%d.%m.%Y %H:%i') AS created,
    		cp.description AS payment,
			o.paymentID AS paymentID,
    		o.invoice_amount AS invoice_amount,
			o.invoice_shipping AS invoice_shipping,
    		o.comment AS comment,
			o.customercomment AS customercomment,
			o.internalcomment AS internalcomment,
			DATE_FORMAT(o.imported,'%d.%m.%Y %H:%i') AS imported,
			DATE_FORMAT(o.ordertime,'%d.%m.%Y %H:%i') AS ordertime,
			o.orderID AS orderID,
			o.ordernumber AS ordernumber,
			b.salutation AS b_salutation,
			b.company AS b_company,
			b.firstname AS b_firstname,
			b.lastname AS b_lastname,
			b.street AS b_street,
			b.streetnumber AS b_streetnumber,
			b.zipcode AS b_zipcode,
			b.city AS b_city,
			b.countryID AS b_countryID,
			ccb.countryname AS b_country,
			b.email AS b_email,
			b.phone AS b_phone,
			b.fax AS b_fax,
			b.birthday AS b_birthday,
			b.additional_address_line1 AS b_additionalAddressLine1,
			b.additional_address_line2 AS b_additionalAddressLine2,
			s.id AS s_id,
			s.company AS s_company,
			s.salutation AS s_salutation,
			s.firstname AS s_firstname,
			s.lastname	AS s_lastname,
			s.street AS s_street,
			s.streetnumber AS s_streetnumber,
			s.zipcode AS s_zipcode,
			s.city AS s_city,
			s.countryID AS s_countryID,
			ccs.countryname AS s_country,
			s.phone AS s_phone,
			s.fax AS s_fax,
			s.additional_address_line1 AS s_additionalAddressLine1,
			s.additional_address_line2 AS s_additionalAddressLine2
		FROM
			s_plugin_externalorder_order AS o
			
		LEFT JOIN
			s_plugin_externalorder_order_billingaddress AS b
			ON b.importOrderID = o.id
			
		LEFT JOIN
			s_plugin_externalorder_order_shippingaddress AS s
			ON s.importOrderID = o.id
			
		LEFT JOIN
			s_plugin_externalorder_account AS eoa
			ON eoa.name = o.account
			
		LEFT JOIN
			s_core_paymentmeans AS cp
			ON cp.id = o.paymentID
			
		LEFT JOIN
			s_core_countries AS ccb
			ON ccb.id = b.countryID
			
		LEFT JOIN
			s_core_countries AS ccs
			ON ccs.id = s.countryID
			
		WHERE
			o.id = ?
		ORDER BY o.created ASC
		LIMIT 1";
		$order = Shopware()->Db()->fetchRow($sql,array($orderID));
		
		if ($order['b_birthday'] == '0000-00-00')
			$order['b_birthday'] = '';
		
		$this->View()->assign(array("success"=>true, "data"=>$order));
	}
	
	public function getOrderAction()
	{
		$request = $this->Request();
		
		$orderID = intval($request->getParam('id', '-1'));
		$limit = intval($request->getParam('limit', 30));
		$start = intval($request->getParam('start', 0));

		// Tabelle sortieren
		$sort = $request->getParam('sort');
		$property = $sort[0]["property"];
		$direction = $sort[0]["direction"];
		if (empty($property)) $property = "articleordernumber";
        if (empty($direction)) $direction = "ASC";

		$sql = "
		SELECT SQL_CALC_FOUND_ROWS eod.id,
			eod.id,
			eod.external_order_number,
			eod.articleordernumber,
			eod.name,
			eod.quantity,
			eod.price,
			(eod.quantity * eod.price) AS totalprice,
			ad.articleID,
			ad.instock
		FROM
			s_plugin_externalorder_order_details AS eod
			
		LEFT JOIN s_articles_details AS ad
		ON ad.ordernumber = eod.articleordernumber
		
		WHERE
			eod.importOrderID = ?
		
		ORDER BY {$property} {$direction}
		LIMIT {$start},{$limit}";
		$order = Shopware()->Db()->fetchAll($sql, array($orderID));
		
		$sqlCount= "SELECT FOUND_ROWS()";
		$count = Shopware()->Db()->fetchOne($sqlCount);
		
		$this->View()->assign(array("success"=>true, "data"=>$order, "total"=>$count));
	}
	
	public function updateCustomerAction()
	{
		$orderID = $this->Request()->getParam('id', null);
		
		if (empty($orderID))
		{
            $this->View()->assign(array("success"=>false));
            return;
        }
		
		$data = $this->Request()->getParams();
		
		$updateOrderData = array(
			'paymentID' => trim($data['paymentID'])
		);
		
		$updateBillingData = array(
			'salutation' 				=> trim($data['b_salutation']),
			'company' 					=> trim($data['b_company']),
			'firstname' 				=> trim($data['b_firstname']),
			'lastname' 					=> trim($data['b_lastname']),
			'street' 					=> trim($data['b_street']),
			'streetnumber' 				=> trim($data['b_streetnumber']),
			'zipcode' 					=> trim($data['b_zipcode']),
			'city' 						=> trim($data['b_city']),
			'countryID' 				=> trim($data['b_countryID']),
			'email' 					=> trim($data['b_email']),
			'phone' 					=> trim($data['b_phone']),
			'fax' 						=> trim($data['b_fax']),
			'birthday' 					=> trim($data['b_birthday']),
			'additional_address_line1' 	=> trim($data['b_additionalAddressLine1']),
			'additional_address_line2' 	=> trim($data['b_additionalAddressLine2'])
		);
		
		$updateShippingData = array(
			'salutation' 				=> trim($data['s_salutation']),
			'company' 					=> trim($data['s_company']),
			'firstname' 				=> trim($data['s_firstname']),
			'lastname' 					=> trim($data['s_lastname']),
			'street' 					=> trim($data['s_street']),
			'streetnumber' 				=> trim($data['s_streetnumber']),
			'zipcode' 					=> trim($data['s_zipcode']),
			'city' 						=> trim($data['s_city']),
			'countryID' 				=> trim($data['s_countryID']),
			'phone' 					=> trim($data['s_phone']),
			'fax' 						=> trim($data['s_fax']),
			'additional_address_line1' 	=> trim($data['s_additionalAddressLine1']),
			'additional_address_line2' 	=> trim($data['s_additionalAddressLine2'])
		);
		
		Shopware()->Db()->update("s_plugin_externalorder_order", $updateOrderData, array('id = ?' => $orderID));
		
		Shopware()->Db()->update("s_plugin_externalorder_order_billingaddress", $updateBillingData, array('importOrderID = ?' => $orderID));
		
		Shopware()->Db()->update("s_plugin_externalorder_order_shippingaddress", $updateShippingData, array('importOrderID = ?' => $orderID));
		
		$this->View()->assign(array("success"=>true, "data"=>$order));
	}
	
	public function generateShopwareOrderAction()
	{
		$namespace = Shopware()->Snippets()->getNamespace('backend/plugins/external_order_log_book/main');
		
		$request = $this->request();
		$orderID = $request->id;
		
		if (empty($orderID))
		{
			$this->View()->assign(array("success"=>false, "errorMsg"=>$namespace->get('logMsgOrderNoOrderId')));
			return;
		}
		
		$order = $this->externalOrderDb->getExternalOrder($orderID);
		if (empty($order['id']))
		{
			$this->View()->assign(array("success"=>false, "errorMsg"=>$namespace->get('logMsgOrderNoFound')));
			return;
		}
		else
		{
			$result = $this->plugin->generateShopwareOrder($order);
			if ($result['success'] == true)
			{
				$this->View()->assign(array("success"=>true));
			}
			else
			{
				$this->View()->assign(array("success"=>false, "errorMsg"=>$result['error_msg']));
			}
		}
	}
	
	public function generateShopwareOrdersAction()
	{
		$request = $this->request();

		$orderIDs = $request->getParam('id', array());
		if (is_string($orderIDs)) {
			$orderIDs = json_decode($orderIDs, true);
		}
		
		$counter = 0;
		foreach($orderIDs as $orderID)
		{
			if (empty($orderID))
			{
				continue;
			}
			
			$order = $this->externalOrderDb->getExternalOrder($orderID);
			if (empty($order['id']))
			{
				continue;
			}
			else
			{
				$result = $this->plugin->generateShopwareOrder($order);
			}
		}
	}
	
	public function importExternalOrderAction()
	{
		$namespace = Shopware()->Snippets()->getNamespace('backend/plugins/external_order_log_book/main');
		
		$request = $this->request();
		$account = $request->account;
		$orderNumber = $request->order_number;
		
		if (empty($orderNumber))
		{
			$this->View()->assign(array("success"=>false, "errorMsg"=>$namespace->get('logMsgEnterOrdernumber')));
			return;
		}
		
		$accountData = $this->getAccount($account);
		
		if (empty($accountData['name']))
		{
			$this->View()->assign(array("success"=>false, "errorMsg"=>$namespace->get('logMsgNoConnectorFound')));
			return;
		}

		/* Splitten */
		$orderNumbers = explode("\n", trim($orderNumber));
		if (count($orderNumbers) < 1)
		{
			$this->View()->assign(array("success"=>false));
			return;
		}
		
		// Begrenzung auf 30 Bestellungen auf einmal, aus Performance Gründen der Marktplätze
		if (count($orderNumbers) > 30)
		{
			$this->View()->assign(array("success"=>false, "errorMsg"=>$namespace->get('logMsgTooManyOrders')));
			return;
		}
		
		// Begrenzung auf 5 Bestellungen auf einmal, da Amazon sonst die Anfrage drosselt
		if (count($orderNumbers) > 5 && $account == 'amazon')
		{
			$this->View()->assign(array("success"=>false, "errorMsg"=>$namespace->get('logMsgTooManyOrdersAmazon')));
			return;
		}
		
		$classname = 'Shopware_Plugins_Backend_'.$accountData['plugin'].'_Bootstrap';
		$object = new $classname($accountData['plugin']);
		
		$countImport = 0;
		foreach ($orderNumbers as $externalOrderNumber)
		{
			$result = $object->importSingleOrder(trim($externalOrderNumber));
			
			if ($result['success'])
			{
				$countImport++;
			}
		}
		
		if ($countImport == 1)
		{
			$this->View()->assign(array("success"=>true));
			return;
		}
		elseif ($countImport > 1)
		{
			$this->View()->assign(array("success"=>true, 'successmsg' => sprintf($namespace->get('logMsgOrdersSuccessfullyImported'), $countImport)));
			return;
		}
		else
		{
			if ($result['error_msg'])
				$this->View()->assign(array("success"=>false, 'errorMsg' => trim($result['error_msg'])));
			else
				$this->View()->assign(array("success"=>false));
				
			return;
		}
	}
	
	public function statusSendOrderAction()
	{
		$namespace = Shopware()->Snippets()->getNamespace('backend/plugins/external_order_log_book/main');
		
		$request = $this->request();
		$orderID = $request->id;
		$account = $request->account;
		
		if (empty($orderID))
		{
			$this->View()->assign(array("success"=>false, "errorMsg"=>$namespace->get('logMsgOrderNoConverted')));
			return;
		}
		
		$accountData = $this->getAccount($account);
		
		if (empty($accountData['name']))
		{
			$this->View()->assign(array("success"=>false, "errorMsg"=>$namespace->get('logMsgNoConnectorFound')));
			return;
		}
		
		$classname = 'Shopware_Plugins_Backend_'.$accountData['plugin'].'_Bootstrap';
		$object = new $classname($accountData['plugin']);
		$result = $object->sendShippingStatus($orderID);
		
		if ($result['success'] == true)
		{
			$this->View()->assign(array("success"=>true));
		}
		else
		{
			if ($result['error_msg'])
				$this->View()->assign(array("success"=>false, 'errorMsg' => trim($result['error_msg'])));
			else
				$this->View()->assign(array("success"=>false, "errorMsg"=>$namespace->get('logMsgLookInLogbook')));
		}
	}
	
	public function getAccount($account)
	{
		$sql = "SELECT * FROM s_plugin_externalorder_account WHERE LOWER(name) = ?";
		return Shopware()->Db()->fetchRow($sql, array(strtolower($account)));
	}
	
	public function DateTimeFromDb($date)
	{
    	$year		= substr($date,0,4);
    	$month		= substr($date,5,2);
    	$day		= substr($date,8,2);
		$hour		= substr($date,11,2);
    	$minute		= substr($date,14,2);
    	$second		= substr($date,17,2);
	
		if (checkdate ($month, $day, $year))
        	return $date = $day.".".$month.".".$year." ".$hour.":".$minute.":".$second;
	}
}

