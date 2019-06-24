<?php
class Shopware_Components_ExternalOrderDb
{
	private $config;

	/** @var Shopware_Components_ExternalOrderBase $externalOrderBase */
	private $externalOrderBase;
	
	private $viison_setarticle_orderid;
	
	public function __construct($config)
    {
        $this->config 				= $config;
		$this->externalOrderBase 	= Shopware()->ExternalOrderBase();
    }
	
	public function getOrdersToGenerate()
	{
		$limit = intval($this->config->create_orderlimit);
		if ($limit < 1)
			$limit = 1;

		$sql = "
		SELECT DISTINCT
			id
		FROM
			s_plugin_externalorder_order

		WHERE
			(orderID IS NULL OR orderID < 1)
		AND
			(generate_error IS NULL OR generate_error < 1)
		AND 
			TIMESTAMPDIFF(SECOND, imported, now()) > 30
		
		ORDER BY created ASC
		
		LIMIT $limit";
		
		return Shopware()->Db()->fetchAll($sql);
	}

	/**
	 * @param $order
	 * @return mixed
	 * @throws Zend_Db_Adapter_Exception
	 * @throws Zend_Db_Statement_Exception
	 */
	public function saveCustomer($order)
	{
		$order['active'] 		= 1;
		$order['accountmode'] 	= 1;
		$order['newsletter'] 	= 0;
		$order['affiliate'] 	= 0;
		
		$order = Shopware()->Events()->filter(
            'Cbax_ExternalOrder_SaveCustomer_BeforeSave',
            $order,
            array('subject' => $this)
        );
		
		$isCustomerAlreadyInSystem = $this->isShopwareCustomerAlreadyInSystem($order['billing']['email']);

		if ($isCustomerAlreadyInSystem)
		{
			$customer = $this->getCustomer($order['billing']['email']);

			$customernumber = $customer->getNumber();
			$password 		= $customer->getPassword();
		}
		else
		{
			$customernumber = $this->getCustomerNumber();
			$password 		= md5(uniqid(rand()));
		}
		
		/* Userdaten */
		$userData = array(
            'password' 						=> $password,
			'email' 						=> trim($order['billing']['email']),
			'active' 						=> $order['active'],
			'accountmode' 					=> $order['accountmode'],
			'confirmationkey' 				=> '',
			'paymentID' 					=> intval($order['paymentID']),
			'firstlogin' 					=> $order["created"],
			'lastlogin' 					=> $order["created"],
			'sessionID' 					=> '',
			'newsletter' 					=> $order['newsletter'],
			'validation' 					=> '',
			'affiliate' 					=> $order['affiliate'],
			'customergroup' 				=> $order['billing']['customergroup'],
			'paymentpreset' 				=> 0,
			'language' 						=> $order['language'],
			'subshopID' 					=> $order['subshopID'],
			'referer' 						=> '',
			'pricegroupID' 					=> NULL,
			'internalcomment' 				=> '',
			'failedlogins' 					=> 0,
			'lockeduntil' 					=> NULL,
			'default_billing_address_id' 	=> '',
			'default_shipping_address_id' 	=> '',
			'title' 						=> trim($order['billing']['title']),
			'salutation' 					=> trim($order['billing']['salutation']),
			'firstname' 					=> trim($order['billing']['firstname']),
			'lastname' 						=> trim($order['billing']['lastname']),
			'birthday' 						=> trim($order['billing']['birthday']),
			'customernumber' 				=> $customernumber
        );
		
		$userBillingAddressesData = $this->prepareAddressesData($order['billing']);
		$userShippingAddressesData = $this->prepareAddressesData($order['shipping']);
		
		/* Rechnungsadresse */
		$userBillingData = array(
			'company' 					=> trim($order['billing']['company']),
			'department' 				=> trim($order['billing']['department']),
			'salutation' 				=> trim($order['billing']['salutation']),
			'firstname' 				=> trim($order['billing']['firstname']),
			'lastname' 					=> trim($order['billing']['lastname']),
			'street' 					=> trim($order['billing']['street']) . ' ' . trim($order['billing']['streetnumber']),
			'zipcode' 					=> trim($order['billing']['zipcode']),
			'city' 						=> trim($order['billing']['city']),
			'phone' 					=> trim($order['billing']['phone']),
			'countryID' 				=> intval($order['billing']['countryID']),
			'stateID' 					=> NULL,
			'ustid' 					=> NULL,
			'additional_address_line1' 	=> trim($order['billing']['additional_address_line1']),
			'additional_address_line2' 	=> trim($order['billing']['additional_address_line2']),
			'title' 					=> trim($order['billing']['title'])
		);
		
		/* Lieferadresse */
		$userShippingData = array(
			'company' 					=> trim($order['shipping']['company']),
			'department' 				=> trim($order['shipping']['department']),
			'salutation' 				=> trim($order['shipping']['salutation']),
			'firstname' 				=> trim($order['shipping']['firstname']),
			'lastname' 					=> trim($order['shipping']['lastname']),
			'street' 					=> trim($order['shipping']['street']).' '.trim($order['shipping']['streetnumber']),
			'zipcode' 					=> trim($order['shipping']['zipcode']),
			'city' 						=> trim($order['shipping']['city']),
			'countryID' 				=> intval($order['shipping']['countryID']),
			'stateID' 					=> NULL,
			'additional_address_line1' 	=> trim($order['shipping']['additional_address_line1']),
			'additional_address_line2' 	=> trim($order['shipping']['additional_address_line2']),
			'title' 					=> trim($order['shipping']['title'])
		);
		
		/* Userdaten in DB speichern */
		if ($isCustomerAlreadyInSystem)
		{
			$userInsertID = $customer->getId();
			
			/* Rechnungsadresse */
			Shopware()->Db()->update('s_user_billingaddress', $userBillingData, array('userID = ?' => $userInsertID));
			
			/* Lieferadresse */
			Shopware()->Db()->update('s_user_shippingaddress', $userShippingData, array('userID = ?' => $userInsertID));

			if (!$this->isAddressAlreadyInSystem($userInsertID, $userBillingAddressesData))
			{
				$userBillingAddressesData['user_id'] = $userInsertID;
				Shopware()->Db()->insert('s_user_addresses', $userBillingAddressesData);
				$userInsertBillingAddressesID = Shopware()->Db()->lastInsertId('s_user_addresses');

				/* Useradressdaten Attribute */
				$userAddressesAttributes = "INSERT INTO s_user_addresses_attributes (address_id) VALUES (?)";
				Shopware()->Db()->query($userAddressesAttributes, array($userInsertBillingAddressesID));
			}

			if (!$this->isAddressAlreadyInSystem($userInsertID, $userShippingAddressesData))
			{
				$userShippingAddressesData['user_id'] = $userInsertID;
				Shopware()->Db()->insert('s_user_addresses', $userShippingAddressesData);
				$userInsertShippingAddressesID = Shopware()->Db()->lastInsertId('s_user_addresses');

				/* Useradressdaten Attribute */
				$userAddressesAttributes = "INSERT INTO s_user_addresses_attributes (address_id) VALUES (?)";
				Shopware()->Db()->query($userAddressesAttributes, array($userInsertShippingAddressesID));
			}
		}
		else
		{
			/* Userdaten */
			Shopware()->Db()->insert('s_user', $userData);
			$userInsertID = Shopware()->Db()->lastInsertId('s_user');
			
			/* Userdaten Attribute */
			$userAttributes = "INSERT INTO s_user_attributes (userID) VALUES (?)";
			Shopware()->Db()->query($userAttributes, array($userInsertID));
			
			/* Useradressdaten */
			$userBillingAddressesData['user_id'] = $userInsertID;
			Shopware()->Db()->insert('s_user_addresses', $userBillingAddressesData);
			$userInsertBillingAddressesID = Shopware()->Db()->lastInsertId('s_user_addresses');
			
			/* Useradressdaten Attribute */
			$userAddressesAttributes = "INSERT INTO s_user_addresses_attributes (address_id) VALUES (?)";
			Shopware()->Db()->query($userAddressesAttributes, array($userInsertBillingAddressesID));
			
			/* Defaultadressen speichern */
			$updateUserData	= "UPDATE s_user SET default_billing_address_id = ?, default_shipping_address_id = ? WHERE id = ?";
			Shopware()->Db()->query($updateUserData, array($userInsertBillingAddressesID, $userInsertBillingAddressesID, $userInsertID));

			if (!$this->isAddressAlreadyInSystem($userInsertID, $userShippingAddressesData)) {
				$userShippingAddressesData['user_id'] = $userInsertID;
				Shopware()->Db()->insert('s_user_addresses', $userShippingAddressesData);
				$userInsertShippingAddressesID = Shopware()->Db()->lastInsertId('s_user_addresses');

				/* Useradressdaten Attribute */
				$userAddressesAttributes = "INSERT INTO s_user_addresses_attributes (address_id) VALUES (?)";
				Shopware()->Db()->query($userAddressesAttributes, array($userInsertShippingAddressesID));

				/* Defaultadressen speichern */
				$updateUserData	= "UPDATE s_user SET default_shipping_address_id = ? WHERE id = ?";
				Shopware()->Db()->query($updateUserData, array($userInsertShippingAddressesID, $userInsertID));
			}
			
			/* Rechnungsadresse */
			$userBillingData['userID'] = $userInsertID;
			Shopware()->Db()->insert('s_user_billingaddress', $userBillingData);
			$userInsertBillingID = Shopware()->Db()->lastInsertId('s_user_billingaddress');
			
			/* Rechnungsadresse Attribute */
			$userBillingaddressAttributes = "INSERT INTO s_user_billingaddress_attributes (billingID) VALUES (?)";
			Shopware()->Db()->query($userBillingaddressAttributes, array($userInsertBillingID));
			
			/* Lieferadresse */
			$userShippingData['userID'] = $userInsertID;
			Shopware()->Db()->insert('s_user_shippingaddress', $userShippingData);
			$userInsertShippingID = Shopware()->Db()->lastInsertId('s_user_shippingaddress');
			
			/* Lieferadresse Attribute */
			$userShippingaddressAttributes = "INSERT INTO s_user_shippingaddress_attributes (shippingID) VALUES (?)";
			Shopware()->Db()->query($userShippingaddressAttributes, array($userInsertShippingID));
			
			/* Workaround */
			/* Geburtsdatum neu speichern, da sonst bei leerem Datum immer 0000-00-00 gespeichert wird */
			$updateUserData	= "UPDATE s_user SET birthday = ? WHERE id = ?";
			Shopware()->Db()->query($updateUserData, array($order['billing']['birthday'], $userInsertID));
		}
		
		Shopware()->Events()->notify(
			'Cbax_ExternalOrder_SaveCustomer_AfterSave',
			array(
				'subject'  			=> $this,
				'customernumber'	=> $customernumber
			)
		);
		
		$result['userInsertID'] = $userInsertID;
		$result['customernumber'] = $customernumber;
		
		return $result;
	}

	/**
	 * @param $addressData
	 * @return array
	 */
	private function prepareAddressesData($addressData)
	{
		return array(
			'company' 					=> trim($addressData['company']),
			'department' 				=> trim($addressData['department']),
			'salutation' 				=> trim($addressData['salutation']),
			'title' 					=> trim($addressData['title']),
			'firstname' 				=> trim($addressData['firstname']),
			'lastname' 					=> trim($addressData['lastname']),
			'street' 					=> trim($addressData['street']) . ' ' . trim($addressData['streetnumber']),
			'zipcode' 					=> trim($addressData['zipcode']),
			'city' 						=> trim($addressData['city']),
			'country_id' 				=> intval($addressData['countryID']),
			'state_id' 					=> NULL,
			'ustid' 					=> NULL,
			'phone' 					=> trim($addressData['phone']),
			'additional_address_line1' 	=> trim($addressData['additional_address_line1']),
			'additional_address_line2' 	=> trim($addressData['additional_address_line2'])
		);
	}

	/**
	 * @param $userId
	 * @param $addressData
	 * @return bool
	 * @throws Zend_Db_Adapter_Exception
	 * @throws Zend_Db_Statement_Exception
	 */
	private function isAddressAlreadyInSystem($userId, $addressData)
	{
		$db = Shopware()->Db();
		$excludedFields = array(
			'fax',
			'phone',
			'state_id',
			'ustid',
			'additional_address_line1',
			'additional_address_line2'
		);
		$where = "`user_id` = ?";

		foreach ($addressData as $key => $value) {
			if (!in_array($key, $excludedFields)) {
				$where .= " AND " . $db->quoteIdentifier($key) . " = " . $db->quote($value);
			}
		}

		$sql = "SELECT `id` FROM `s_user_addresses` WHERE $where;";
		return ($db->query($sql, array($userId))->rowCount() > 0);
	}
	
	private function getViisonSetArticles($order)
	{
		foreach ($order['details'] as $article)
		{
			$sql = "
			SELECT
				at.viison_setarticle_active
			FROM
				s_articles_details AS ad,
				s_articles_attributes AS at
			WHERE
				ad.id = at.articledetailsID
			AND
				ad.ordernumber = ?";
			$sArticleData = Shopware()->Db()->fetchRow($sql, array(trim($article['articleordernumber'])));
			
			$result["id"] 						= $article["id"];
			$result["importOrderID"] 			= $article["importOrderID"];
			$result["external_order_number"]	= $article["external_order_number"];
			$result["articleordernumber"] 		= $article["articleordernumber"];
			$result["name"] 					= $article['name'];
			$result["price"] 					= $article["price"];
			$result["quantity"] 				= $article["quantity"];
			$result["modus"] 					= $article["modus"];
			$result["taxID"] 					= $article['taxID'];
			$result["tax_rate"] 				= $article['tax_rate'];
			$result["attribute1"] 				= $article['attribute1'];
			$result["attribute2"] 				= $article['attribute2'];
			$result["attribute3"] 				= $article['attribute3'];
			$result["viison_setarticle_active"] = $sArticleData['viison_setarticle_active'];
			
			$order['articledetails'][] = $result;
			
			if ($sArticleData['viison_setarticle_active'])
			{	
				$sqlArticle = "
				SELECT
					avsa.articledetailid,
					avsa.quantity
				FROM
					s_articles_viison_setarticles AS avsa
				
				LEFT JOIN s_articles_details AS ad
				ON ad.id = avsa.setid
				
				WHERE
					ad.ordernumber = ?
				";
				$setarticles = Shopware()->Db()->fetchAll($sqlArticle, array($article['articleordernumber']));
				
				if (count($setarticles) > 0)
				{
					foreach ($setarticles as $setarticle)
					{
						$sqlSetArticle = "
						SELECT
							a.name AS name,
							a.taxID,
							ad.ordernumber,
							t.tax
						FROM
							s_articles AS a
						
						LEFT JOIN s_articles_details AS ad
						ON ad.articleID = a.id
						
						JOIN s_core_tax AS t
						ON t.id = a.taxID
						
						WHERE
							ad.id = ?
						";
						
						$set = Shopware()->Db()->fetchRow($sqlSetArticle, array($setarticle['articledetailid']));
						
						$result_set["id"] 						= $article["id"];
						$result_set["importOrderID"] 			= $article["importOrderID"];
						$result_set["external_order_number"]	= $article["external_order_number"];
						$result_set["articleordernumber"] 		= $set["ordernumber"];
						$result_set["name"] 					= 'Stücklisten-Artikel '.$article['articleordernumber'].': '.$set["name"];
						$result_set["price"] 					= '0.00';
						$result_set["quantity"] 				= ($article['quantity'] * $setarticle["quantity"]);
						$result_set["modus"] 					= 0;
						$result_set["taxID"] 					= $set['taxID'];
						$result_set["tax_rate"] 				= $this->externalOrderBase->getTaxRateByConditions($order, $set['taxID']);
						$result_set["attribute1"] 				= '';
						$result_set["attribute2"] 				= '';
						$result_set["attribute3"] 				= '';
						$result_set["viison_setarticle_active"] = $sArticleData['viison_setarticle_active'];
						$result_set["viison_setarticle"] 		= 1;
						
						$order['articledetails'][] = $result_set;
					}
				}
			}
		}
		
		return $order['articledetails'];
	}

	/**
	 * @param $order
	 * @return mixed
	 * @throws Enlight_Event_Exception
	 * @throws Zend_Db_Adapter_Exception
	 * @throws Zend_Db_Statement_Exception
	 */
	public function saveShopwareOrder($order)
	{
		if (empty($order['language']))
		{
			$shop = Shopware()->Models()->getRepository('Shopware\Models\Shop\Shop')->find($order["subshopID"]);
        	$shop->registerResources(Shopware()->Bootstrap());

			$order['language'] = $shop->getId();
		}
		
		// Stücklisten Artikel von Pickware holen
		if ($this->externalOrderBase->columnExist('s_articles_attributes', 'viison_setarticle_active'))
		{
			$order['details'] = $this->getViisonSetArticles($order);
		}
		
		if ($order['billing']['birthday'] == '0000-00-00')
		{
			$order['billing']['birthday'] = NULL;
		}
		
		/* Bestellnummer */
		$order['ordernumber'] = Shopware()->Modules()->Order()->sGetOrderNumber();
		
		$order = Shopware()->Events()->filter(
            'Cbax_ExternalOrder_SaveShopwareOrder_BeforeSave',
            $order,
            array('subject' => $this)
        );

		$result = $this->saveCustomer($order);
		
		$userInsertID = $result['userInsertID'];
		$customernumber = $result['customernumber'];
		
		/* Bestellung */
		$insertOrderData = array(
			'ordernumber' 			=> $order['ordernumber'],
			'userID' 				=> $userInsertID,
			'invoice_amount' 		=> doubleval($order['invoice_amount']),
			'invoice_amount_net' 	=> doubleval($order['invoice_amount_net']),
			'invoice_shipping' 		=> doubleval($order['invoice_shipping']),
			'invoice_shipping_net' 	=> round(doubleval($order['invoice_shipping_net']),2),
			'ordertime' 			=> $order['created'],
			'status' 				=> intval($order['status']),
			'cleared' 				=> intval($order['cleared']),
			'paymentID' 			=> intval($order['paymentID']),
			'transactionID' 		=> trim($order['transactionID']),
			'comment' 				=> trim($order['comment']),
			'customercomment' 		=> trim($order['customercomment']),
			'internalcomment' 		=> trim($order['internalcomment']),
			'net' 					=> 0,
			'taxfree' 				=> 0,
			'partnerID' 			=> trim($order['account']),
			'temporaryID' 			=> '',
			'referer' 				=> '',
			'cleareddate' 			=> NULL,
			'trackingcode' 			=> '',
			'language' 				=> $order['language'],
			'dispatchID' 			=> intval($order['dispatchID']),
			'currency' 				=> trim($order['currency_currency']),
			'currencyFactor' 		=> doubleval($order['currency_factor']),
			'subshopID' 			=> $order['subshopID'],
			'remote_addr' 			=> '',
			'deviceType' 			=> $order['account']
		);
		
		if ($this->assertVersionGreaterThen('5.5.0'))
		{
			$insertOrderData['invoice_shipping_tax_rate'] = doubleval($order['invoice_shipping_tax_rate']);
		}
		
		Shopware()->Db()->insert('s_order', $insertOrderData);
		
		$orderInsertID = Shopware()->Db()->lastInsertId('s_order');
		
		/* Bestellung Attribute */
		$attributeData = array(
			'orderID' 									=> $orderInsertID,
			'attribute1' 								=> $order['attribute1'],
			'attribute2' 								=> $order['attribute2'],
			'attribute3' 								=> $order['attribute3'],
			'cbax_external_order_carrier' 				=> $order['carrier'],
			'cbax_external_order_payment_instruction' 	=> $order['payment_instruction']
		);
		Shopware()->Db()->insert('s_order_attributes', $attributeData);
		
		/* Externe Bestellnummer speichern */
		$sql = "UPDATE s_order_attributes SET `cbax_external_order_ordernumber` = ? WHERE orderID = ?";
		Shopware()->Db()->query($sql, array($order['external_order_number'], $orderInsertID));
		
		/* Rechnungsadresse Straße und Nummer getrennt */
		$insertOrderBillingData = array(
			'userID' 					=> $userInsertID,
			'orderID' 					=> $orderInsertID,
			'company' 					=> trim($order['billing']['company']),
			'department' 				=> trim($order['billing']['department']),
			'salutation' 				=> trim($order['billing']['salutation']),
			'customernumber' 			=> $customernumber,
			'firstname' 				=> trim($order['billing']['firstname']),
			'lastname' 					=> trim($order['billing']['lastname']),
			'street' 					=> trim($order['billing']['street']).' '.trim($order['billing']['streetnumber']),
			'zipcode' 					=> trim($order['billing']['zipcode']),
			'city' 						=> trim($order['billing']['city']),
			'phone' 					=> trim($order['billing']['phone']),
			'countryID' 				=> intval($order['billing']['countryID']),
			'stateID' 					=> NULL,
			'ustid' 					=> NULL,
			'additional_address_line1' 	=> trim($order['billing']['additional_address_line1']),
			'additional_address_line2' 	=> trim($order['billing']['additional_address_line2'])
		);
		
		Shopware()->Db()->insert('s_order_billingaddress', $insertOrderBillingData);
		
		$sqlInsertBillingID = Shopware()->Db()->lastInsertId('s_order_billingaddress');
		
		/* Rechnungsadresse Attribute */
        $attributeData = array(
            'billingID' => $sqlInsertBillingID,
			'text1' 	=> $order['billing']['text1'],
			'text2' 	=> $order['billing']['text2'],
			'text3' 	=> $order['billing']['text3']
        );
		Shopware()->Db()->insert('s_order_billingaddress_attributes', $attributeData);
		
		/* Lieferadresse Straße und Nummer getrennt */
		$insertOrderShippingData = array(
			'userID' 					=> $userInsertID,
			'orderID' 					=> $orderInsertID,
			'company' 					=> trim($order['shipping']['company']),
			'department' 				=> trim($order['shipping']['department']),
			'salutation' 				=> trim($order['shipping']['salutation']),
			'firstname' 				=> trim($order['shipping']['firstname']),
			'lastname' 					=> trim($order['shipping']['lastname']),
			'street' 					=> trim($order['shipping']['street']).' '.trim($order['shipping']['streetnumber']),
			'zipcode' 					=> trim($order['shipping']['zipcode']),
			'city' 						=> trim($order['shipping']['city']),
			'countryID' 				=> trim($order['shipping']['countryID']),
			'stateID' 					=> NULL,
			'additional_address_line1' 	=> trim($order['shipping']['additional_address_line1']),
			'additional_address_line2' 	=> trim($order['shipping']['additional_address_line2'])
		);
		
		Shopware()->Db()->insert('s_order_shippingaddress', $insertOrderShippingData);
		
		$sqlInsertShippingID = Shopware()->Db()->lastInsertId('s_order_shippingaddress');
		
		/* Lieferadresse Attribute */
        $attributeData = array(
            'shippingID' => $sqlInsertShippingID,
			'text1' 	 => $order['shipping']['text1'],
			'text2' 	 => $order['shipping']['text2'],
			'text3' 	 => $order['shipping']['text3']
        );
		Shopware()->Db()->insert('s_order_shippingaddress_attributes', $attributeData);
		
		/* Artikel */
		foreach ($order['details'] as $article)
		{
			$sql = "
			SELECT
				a.id AS articleID,
				a.datum AS releasedate,
				ad.id AS articledetailsID,
				ad.ean,
				ad.packunit
			FROM
				s_articles AS a,
				s_articles_details AS ad
			WHERE
				a.id = ad.articleID
			AND
				ad.ordernumber = ?";
			$sArticleData = Shopware()->Db()->fetchRow($sql, array(trim($article['articleordernumber'])));
			
			if (!$sArticleData['articleID'])
			{
				$sArticleData['articleID'] 			= 0;
				$sArticleData['articleDetailID'] 	= 0;
				$sArticleData['releasedate'] 		= '0000-00-00';
			}
			
			/* Artikel Detail */
			$insertOrderDetailData = array(
            	'orderID' 				=> $orderInsertID,
				'ordernumber' 			=> $order['ordernumber'],
				'articleID' 			=> $sArticleData['articleID'],
				'articleordernumber' 	=> $article['articleordernumber'],
				'price' 				=> $article['price'],
				'quantity' 				=> $article['quantity'],
				'name' 					=> $article['name'],
				'status' 				=> 0,
				'shipped' 				=> 0,
				'shippedgroup' 			=> 0,
				'releasedate' 			=> $sArticleData['releasedate'],
				'modus' 				=> intval($article['modus']),
				'esdarticle' 			=> 0,
				'taxID' 				=> intval($article['taxID']),
				'tax_rate' 				=> $article['tax_rate'],
				'config' 				=> '',
				'ean' 					=> $sArticleData['ean'],
				'unit' 					=> $sArticleData['unit'],
				'pack_unit' 			=> $sArticleData['packunit']
        	);
			
			if ($this->assertVersionGreaterThen('5.5.0'))
			{
				$insertOrderDetailData['articleDetailID'] = $sArticleData['articledetailsID'];
			}
			
			Shopware()->Db()->insert('s_order_details', $insertOrderDetailData);
			
			$sqlInsertDetailID = Shopware()->Db()->lastInsertId('s_order_details');
			
			/* Artikel Detail Attribute */
        	$attributeData = array(
            	'detailID'   => $sqlInsertDetailID,
				'attribute1' => $article['attribute1'],
				'attribute2' => $article['attribute2'],
				'attribute3' => $article['attribute3']
        	);
			Shopware()->Db()->insert('s_order_details_attributes', $attributeData);
			
			$sqlInsertOrderDetailsAttributesID = Shopware()->Db()->lastInsertId('s_order_details_attributes');
			
			// Stücklisten Artikel von Pickware als Set zusätzlich abspeichern
			// damit aus dem Set nicht einzelne Artikel sondern nur das komplette Set gelöscht werden kann
			if (($article['viison_setarticle_active']) && (!$article['viison_setarticle']))
				$this->viison_setarticle_orderid = $sqlInsertDetailID;
			
			if (!$article['viison_setarticle_active'])
				$this->viison_setarticle_orderid = '';
			
			if ($this->viison_setarticle_orderid)
			{
				$sqlUpdate	= "UPDATE s_order_details_attributes SET viison_setarticle_orderid = ? WHERE id = ?";
				Shopware()->Db()->query($sqlUpdate, array($this->viison_setarticle_orderid, $sqlInsertOrderDetailsAttributesID));
			}
			
			// Lagerbestand aktualisieren
			if (!$order['dropshipping'])
			{
				Shopware()->Db()->query("UPDATE s_articles_details SET sales=sales+?, instock=instock-? WHERE ordernumber=?",array($article['quantity'], $article['quantity'], $article['articleordernumber']));
			}
		}
		
		/* Import-Datensatz auf erstellt setzen */
		$sqlUpdate	= "UPDATE s_plugin_externalorder_order SET ordertime = now(), orderID = ?, ordernumber = ? WHERE id = ?";
		Shopware()->Db()->query($sqlUpdate, array($orderInsertID, $order['ordernumber'], $order['id']));

		Shopware()->Events()->notify(
			'Cbax_ExternalOrder_SaveShopwareOrder_AfterSave',
			array(
				'subject'  		=> $this,
				'ordernumber'	=> $order['ordernumber']
			)
		);
		
		$result['ordernumber'] = $order['ordernumber'];
		$result['success'] = true;
		return $result;

	}

	/**
	 * @param $order
	 * @return mixed
	 * @throws Enlight_Event_Exception
	 * @throws Zend_Db_Adapter_Exception
	 */
	public function saveExternalOrder($order)
	{
		if (!$order['carrier']) {
			$accountConfig = $this->externalOrderBase->getAccountConfig($order['account']);
			$order['carrier'] = (array_key_exists('dispatch_carrier', $accountConfig)) ? $accountConfig['dispatch_carrier'] : '';
		}
		
		if (empty($order['billing']['firstname']) && empty($order['billing']['company']))
			$order['billing']['firstname'] = 'Familie';
			
		if (empty($order['shipping']['firstname']) && empty($order['shipping']['company']))
			$order['shipping']['firstname'] = 'Familie';
		
		$order = Shopware()->Events()->filter(
            'Cbax_ExternalOrder_SaveExternalOrder_BeforeSave',
            $order,
            array('subject' => $this)
        );

		$tax_rate = $this->externalOrderBase->getTaxRateByConditions($order);
		
		/* Bestellung */
		$insertOrderData = array(
            'account' 					=> trim($order['account']),
			'external_order_number' 	=> trim($order['external_order_number']),
			'created' 					=> trim($order['created']),
			'invoice_amount' 			=> doubleval($order['invoice_amount']),
			'invoice_amount_net' 		=> doubleval($this->externalOrderBase->getNetto($order['invoice_amount'], $tax_rate)),
			'invoice_shipping' 			=> doubleval($order['invoice_shipping']),
			'invoice_shipping_net' 		=> doubleval($this->externalOrderBase->getNetto($order['invoice_shipping'], $tax_rate)),
			'invoice_shipping_tax_rate' => doubleval($tax_rate),
			'status' 					=> intval($order['status']),
			'cleared' 					=> intval($order['cleared']),
			'paymentID' 				=> intval($order['paymentID']),
			'transactionID' 			=> trim($order['transactionID']),
			'comment' 					=> trim($order['comment']),
			'customercomment' 			=> trim($order['customercomment']),
			'internalcomment' 			=> trim($order['internalcomment']),
			'payment_instruction' 		=> trim($order['payment_instruction']),
			'dispatchID' 				=> intval($order['dispatchID']),
			'currency_currency' 		=> trim($order['currency_currency']),
			'currency_factor' 			=> doubleval($order['currency_factor']),
			'dropshipping' 				=> intval($order['dropshipping']),
			'imported' 					=> date('Y-m-d H:i:s'),
			'subshopID' 				=> intval($order['subshopID']),
			'taxID' 					=> intval($order['taxID']),
			'ordertime' 				=> NULL,
			'orderID' 					=> NULL,
			'ordernumber' 				=> NULL,
			'carrier'					=> trim($order['carrier']),
			'trackingcode' 				=> NULL,
			'shipped_to_account'		=> 0,
			'attribute1' 				=> trim($order['attribute1']),
			'attribute2' 				=> trim($order['attribute2']),
			'attribute3' 				=> trim($order['attribute3'])
        );
		Shopware()->Db()->insert('s_plugin_externalorder_order', $insertOrderData);

		$orderID = Shopware()->Db()->lastInsertId();
		
		/* Rechnungsadresse */
		$insertOrderBillingData = array(
            'importOrderID' 			=> $orderID,
			'customergroup' 			=> trim($order['billing']['customergroup']),
			'salutation' 				=> trim($order['billing']['salutation']),
			'company' 					=> trim($order['billing']['company']),
			'firstname' 				=> trim($order['billing']['firstname']),
			'lastname' 					=> trim($order['billing']['lastname']),
			'street' 					=> trim($order['billing']['street']),
			'streetnumber' 				=> trim($order['billing']['streetnumber']),
			'zipcode' 					=> trim($order['billing']['zipcode']),
			'city' 						=> trim($order['billing']['city']),
			'countryID' 				=> intval($order['billing']['countryID']),
			'email' 					=> trim($order['billing']['email']),
			'phone' 					=> trim($order['billing']['phone']),
			'fax' 						=> trim($order['billing']['fax']),
			'birthday' 					=> trim($order['billing']['birthday']),
			'additional_address_line1' 	=> trim($order['billing']['additional_address_line1']),
			'additional_address_line2' 	=> trim($order['billing']['additional_address_line2']),
			'text1' 					=> trim($order['billing']['text1']),
			'text2' 					=> trim($order['billing']['text2']),
			'text3' 					=> trim($order['billing']['text3'])
        );
		Shopware()->Db()->insert('s_plugin_externalorder_order_billingaddress', $insertOrderBillingData);
		
		/* Lieferadresse */
		$insertOrderShippingData = array(
            'importOrderID' => $orderID,
			'salutation' 				=> trim($order['shipping']['salutation']),
			'company' 					=> trim($order['shipping']['company']),
			'firstname' 				=> trim($order['shipping']['firstname']),
			'lastname' 					=> trim($order['shipping']['lastname']),
			'street' 					=> trim($order['shipping']['street']),
			'streetnumber' 				=> trim($order['shipping']['streetnumber']),
			'zipcode' 					=> trim($order['shipping']['zipcode']),
			'city' 						=> trim($order['shipping']['city']),
			'countryID' 				=> intval($order['shipping']['countryID']),
			'phone' 					=> trim($order['shipping']['phone']),
			'fax' 						=> trim($order['shipping']['fax']),
			'additional_address_line1' 	=> trim($order['shipping']['additional_address_line1']),
			'additional_address_line2' 	=> trim($order['shipping']['additional_address_line2']),
			'text1' 					=> trim($order['shipping']['text1']),
			'text2' 					=> trim($order['shipping']['text2']),
			'text3' 					=> trim($order['shipping']['text3'])
        );
		Shopware()->Db()->insert('s_plugin_externalorder_order_shippingaddress', $insertOrderShippingData);

		/* Artikel */
		foreach ($order['details'] as $detail)
		{
			if (isset($order['config']))
			{
				$article = $this->externalOrderBase->getArticle($order, $detail['articleordernumber'], $detail['name']);
				$detail['name']		= $article['name'];
				$detail['taxID']	= $article['taxID'];
				$detail['tax_rate']	= $article['tax_rate'];
			}

			/* Artikel Detail */
			$insertOrderDetailData = array(
            	'importOrderID' 			=> $orderID,
				'external_order_number' 	=> trim($order['external_order_number']),
				'external_article_number' 	=> trim($detail['external_article_number']),
				'articleordernumber' 		=> trim($detail['articleordernumber']),
				'name' 						=> trim($detail['name']),
				'price' 					=> doubleval($detail['price']),
				'quantity' 					=> intval($detail['quantity']),
				'modus' 					=> intval($detail['modus']),
				'taxID' 					=> intval($detail['taxID']),
				'tax_rate' 					=> doubleval($detail['tax_rate']),
				'attribute1' 				=> trim($detail['attribute1']),
				'attribute2' 				=> trim($detail['attribute2']),
				'attribute3' 				=> trim($detail['attribute3'])
        	);
			Shopware()->Db()->insert('s_plugin_externalorder_order_details', $insertOrderDetailData);
		}
		
		if ($order['invoice_shipping'] != 0)
		{
			// Netto Versandkosten in Abhängikeit von den MwSt Einstellungen im Shopware Versandkostenmodul neu berechnen
			$invoice_shipping_net = $this->externalOrderBase->getInvoiceShippingNetto($order);
			$sqlUpdate	= "UPDATE s_plugin_externalorder_order SET invoice_shipping_net = ? WHERE external_order_number = ?";
			Shopware()->Db()->query($sqlUpdate, array(doubleval($invoice_shipping_net), $order['external_order_number']));
		}

		Shopware()->Events()->notify(
			'Cbax_ExternalOrder_SaveExternalOrder_AfterSave',
			array(
				'subject' => $this,
				'externalordernumber' => $order['external_order_number']
			)
		);
		
		$result['external_order_number'] = $order['external_order_number'];
		$result['success'] = true;
		return $result;
	}
	
	public function getExternalOrder($orderID)
	{
		$sql = "SELECT * FROM s_plugin_externalorder_order WHERE id = ?";
		$order = Shopware()->Db()->fetchRow($sql, array($orderID));
		
		$sql = "SELECT * FROM s_plugin_externalorder_order_details WHERE importOrderID = ?";
		$orderDetails = Shopware()->Db()->fetchAll($sql, array($orderID));
		$order['details'] = $orderDetails;
		
		$sql = "SELECT * FROM s_plugin_externalorder_order_billingaddress WHERE importOrderID = ?";
		$orderBilling = Shopware()->Db()->fetchRow($sql, array($orderID));
		$order['billing'] = $orderBilling;
		
		$sql = "SELECT * FROM s_plugin_externalorder_order_shippingaddress WHERE importOrderID = ?";
		$orderShipping = Shopware()->Db()->fetchRow($sql, array($orderID));
		$order['shipping'] = $orderShipping;
		
		return $order;
	}

	/**
	 * @return int|string
	 * @throws Zend_Db_Adapter_Exception
	 */
	private function getCustomerNumber()
	{
		$customernumber = '';
		
		// Kundennummer nur setzen, wenn Einstellung "Shopware generiert Kundennummern" aktiviert
		if (Shopware()->Config()->get('shopwareManagedCustomerNumbers'))
		{
			$sql = "/*NO LIMIT*/ SELECT number FROM s_order_number WHERE name='user' FOR UPDATE";
			$customernumber = Shopware()->Db()->fetchOne($sql);
			$sql = "UPDATE s_order_number SET number=number+1 WHERE name='user'";
			Shopware()->Db()->query($sql);
			$customernumber += 1;
		}
		
		return $customernumber;
	}
	
	/**
     * @param string $email
     * @return Shopware\Models\Customer\Customer
     */
    private function getCustomer($email)
	{
        return Shopware()->Models()->getRepository('\Shopware\Models\Customer\Customer')->findOneBy(array('email' => $email));
    }
	
	private function isShopwareOrderAlreadyInSystem($external_order_number)
	{
		$sql = "
		SELECT
			COUNT(id)
		FROM
			s_order_attributes
		WHERE
			cbax_external_order_ordernumber = ?";
		$count = Shopware()->Db()->fetchOne($sql, array($external_order_number));

		return (intval($count)>0);
	}
	
	private function isShopwareCustomerAlreadyInSystem($email)
	{
		$sql = "
		SELECT
			COUNT(id)
		FROM
			s_user
		WHERE
			email = ?";
		$count = Shopware()->Db()->fetchOne($sql, array($email));

		return (intval($count)>0);
	}
	
	public function isOrderAlwaysInSystem($external_order_number)
	{
		return $this->isOrderAlreadyInSystem($external_order_number);
	}

	public function isOrderAlreadyInSystem($external_order_number)
	{
		$sql = "
		SELECT
			COUNT(id)
		FROM
			s_plugin_externalorder_order
		WHERE
			external_order_number = ?
		OR
			transactionID = ?";
		$count = Shopware()->Db()->fetchOne($sql, array($external_order_number, $external_order_number));

		return (intval($count)>0);
	}
	
	public function checkOrderForImport($order)
	{
		$namespace = Shopware()->Snippets()->getNamespace('backend/plugins/external_order_log_book/main');
		
		$result['success'] = false;
		
		 // Kann benutzt werden, um den Import einer Bestellung vor dem Check abzubrechen oder die Überprüfung zu manipulieren
		$order = Shopware()->Events()->filter(
            'Cbax_ExternalOrder_CheckOrderForImport_BeforeCheck',
            $order,
            array('subject' => $this)
        );
		
		// Überprüfung des Events
		if ($order['error_msg'])
		{
			$result['error_msg'] = $order['error_msg'];
			return $result;
		}
		
		// Überprüfung der Bestellnummer
		if (empty($order['external_order_number']))
		{
			$result['error_msg'] = $namespace->get('logMsgOrderNoOrdernumber');
			return $result;
		}
		
		// Überprüfung der Währung  - z.B. für Amazon UK
		if (empty($order['currency_currency']))
		{
			$result['error_msg'] = $namespace->get('logMsgOrderNoCurrency');
			return $result;
		}
		
		// Überprüfung der Bestellpositionen
		if ((count($order['details']) < 1) || !is_array($order['details'][0]))
		{
			$result['error_msg'] = sprintf($namespace->get('logMsgOrderNoOrderItems'), $order['external_order_number']);
			return $result;
		}
		
		// Überprüfung der Zahlungsart
		if (intval($order['paymentID']) < 1)
		{
			$result['error_msg'] = sprintf($namespace->get('logMsgOrderNoPayment'), $order['external_order_number']);
			return $result;
		}
		
		// Überprüfung der Gesamtsumme
		if (doubleval($order['invoice_amount']) < 0)
		{
			$result['error_msg'] = sprintf($namespace->get('logMsgOrderNoAmount'), $order['external_order_number']);
			return $result;
		}
		
		$result['success'] = true;
		return $result;
	}

	/**
	 * @param $order
	 * @return mixed
	 * @throws Enlight_Event_Exception
	 * @throws Zend_Db_Adapter_Exception
	 */
	public function importOrderInDb($order)
	{
		$namespace = Shopware()->Snippets()->getNamespace('backend/plugins/external_order_log_book/main');
		
		$result['success'] = false;
		
		$checkOrder = $this->checkOrderForImport($order);
		if (!$checkOrder['success'])
		{
			return $checkOrder;
		}
		
		$isInSystem = $this->isOrderAlreadyInSystem($order['external_order_number']);
		if ($isInSystem)
		{
			$result['success'] = false;
			$result['error_msg'] = $namespace->get('logMsgOrderAlreadyInSystem');
			return $result;
		}
		
		$result = $this->saveExternalOrder($order);
		
		return $result;
	}

	/**
	 * @param $order
	 * @return mixed
	 * @throws Zend_Db_Adapter_Exception
	 */
	public function checkOrderForGenerate($order)
	{
		$namespace = Shopware()->Snippets()->getNamespace('backend/plugins/external_order_log_book/main');
		
		// Prüfung ob Shopware-Bestellung bereits generiert
		if ($this->isShopwareOrderAlreadyInSystem($order['external_order_number']))
		{
			$result['error_msg'] = $namespace->get('logMsgAlreadyConverted');
			$result['success'] = false;
			return $result;
		}
		
		// Überprüfung der Adressdaten
		$requiredFields = array('firstname', 'lastname', 'street', 'streetnumber', 'zipcode', 'city', 'countryID');
		foreach ($requiredFields as $requiredField)
		{
			if (empty($order['billing'][$requiredField]) || empty($order['shipping'][$requiredField]))
			{
				$sql = "UPDATE s_plugin_externalorder_order SET generate_error = 1 WHERE id = ?";
				Shopware()->Db()->query($sql, array($order['id']));
				
				$errorArray = array(
					'Account' => $order['account'],
					'Bestellnummer' => $order['external_order_number'],
					'Typ' => $namespace->get('logTypeError'),
					'Request' => $order
				);
				
				$this->externalOrderBase->doLog(
					$order['account'],
					$namespace->get('logTypeError'),
					sprintf($namespace->get('logMsgAddressDataMissing'), $order['external_order_number']),
					$namespace->get('logActionCreateShopwareOrder'),
					print_r($errorArray, true)
				);
				
				$result['error_msg'] = $namespace->get('logMsgAddressDataMissing2');
				$result['success'] = false;
				return $result;
			}
		}

		$result['success'] = true;
		return $result;
	}

	/**
	 * @param $account
	 * @param string $orderID
	 * @return array|mixed
	 */
	public function getSendOrders($account, $orderID = '')
	{
		$accountConfig = Shopware()->ExternalOrderBase()->getAccountConfig($account);

		if ($orderID)
		{
			// Einzelne versendete Bestellung eines Account holen
			$sql = "
			SELECT
				id, external_order_number, ordernumber, carrier, trackingcode, transactionID
			FROM
				s_plugin_externalorder_order
			WHERE
				shipped_to_account = 1
			AND
				account = ?
			AND 
				id = ?";
			$external_order = Shopware()->Db()->fetchRow($sql, array($account, $orderID));
			
			$sql = "SELECT * FROM s_plugin_externalorder_order_details WHERE importOrderID = ?";
			$external_order_detail = Shopware()->Db()->fetchAll($sql, array($external_order['id']));
			
			$external_order['details'] = $external_order_detail;

			if (empty($external_order['carrier'])) {
				$external_order['carrier'] = (array_key_exists('dispatch_carrier', $accountConfig)) ? $accountConfig['dispatch_carrier'] : '';
			}
			
			return $external_order;
		}
		else
		{
			// Alle versendeten Bestellungen eines Account holen
			$sql = "
			SELECT
				id, external_order_number, ordernumber, carrier, trackingcode, transactionID
			FROM
				s_plugin_externalorder_order
			WHERE
				shipped_to_account = 1
			AND 
				account = ?";
			$external_orders = Shopware()->Db()->fetchAll($sql, array($account));
			
			foreach ($external_orders as &$external_order)
			{
				$sql = "SELECT * FROM s_plugin_externalorder_order_details WHERE importOrderID = ?";
				$external_order_detail = Shopware()->Db()->fetchAll($sql, array($external_order['id']));
				$external_order['details'] = $external_order_detail;

				if (empty($external_order['carrier'])) {
					$external_order['carrier'] = (array_key_exists('dispatch_carrier', $accountConfig)) ? $accountConfig['dispatch_carrier'] : '';
				}
			}
			
			return $external_orders;
		}
	}

	/**
	 * @param $external_order_number
	 * @throws Zend_Db_Adapter_Exception
	 */
	public function saveShippingStatusSuccess($external_order_number)
	{
		if (!empty($external_order_number))
		{
			$sql = "UPDATE s_plugin_externalorder_order SET shipped_to_account = 2 WHERE shipped_to_account = 1 AND external_order_number = ?";
			Shopware()->Db()->query($sql, array($external_order_number));
		}
	}

	/**
	 * @param $external_order_number
	 * @throws Zend_Db_Adapter_Exception
	 */
	public function saveShippingStatusWarning($external_order_number)
	{
		if (!empty($external_order_number))
		{
			$sql = "UPDATE s_plugin_externalorder_order SET shipped_to_account = 3 WHERE shipped_to_account = 1 AND external_order_number = ?";
			Shopware()->Db()->query($sql, array($external_order_number));
		}
	}
	
	/**
     * Check if a given version is greater or equal to
     * the currently installed shopware version.
     *
     * @return bool
     */
	protected function assertVersionGreaterThen($requiredVersion)
    {
        if (Shopware::VERSION === '___VERSION___') {
            return true;
        }

        return version_compare(Shopware::VERSION, $requiredVersion, '>=');
    }
}