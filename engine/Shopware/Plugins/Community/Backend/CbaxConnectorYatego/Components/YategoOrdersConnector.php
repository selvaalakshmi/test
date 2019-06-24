<?php
class Shopware_Components_YategoOrdersConnector
{
	private $constants;
	
	private $settings;

	/** @var Shopware_Components_ExternalOrderBase */
	private $externalOrderBase;

	/** @var Shopware_Components_ExternalOrderDb */
	private $externalOrderDb;
	
	/** @var Shopware_Components_YategoOrdersBase */
	private $yategoBase;
	
	/** @var Shopware_Components_YategoOrdersClient */
	private $yategoClient;
	
	public function __construct($constants, $settings)
    {
		$this->externalOrderBase 	= Shopware()->ExternalOrderBase();
		$this->externalOrderDb 		= Shopware()->ExternalOrderDb();
		$this->yategoBase		 	= Shopware()->YategoOrdersBase();
		$this->yategoClient 		= Shopware()->YategoOrdersClient();
		
       $this->constants 	= $constants;
        $this->settings 	= $settings;
    }
	
	/**
	 * Automatischer import der nächsten externen Bestellunge
	 * @return bool
	 */
	public function importOrderAutomatic()
	{
		$namespace = Shopware()->Snippets()->getNamespace('backend/plugins/external_order_log_book/main');
		
		$dataOrders = $this->yategoClient->getOrders();
		
		if ($dataOrders)
		{
			$counter = 0;
			foreach ($dataOrders as $order)
			{
				$ordernumber = trim($order['Bestellnummer']);
				// Bestellung befindet sich bereits im System
				if ($this->externalOrderDb->isOrderAlreadyInSystem($ordernumber))
				{
					continue;
				}
				
				// Positionen holen
				$order['order_details'] = $this->yategoClient->getOrderPosition($ordernumber);
				
				$importOrder = $this->convertOrderDataForImport($order);
				
				$result = $this->externalOrderDb->importOrderInDb($importOrder);
				// Fehler beim Speichern der Bestellung
				if ($result['success'] != true)
				{
					$errorArray = array(
						'Account' => $this->constants['account_description'],
						'Bestellnummer' => $ordernumber,
						'Typ' => $namespace->get('logTypeError'),
						'Response' => $order,
						'Array' => $importOrder
					);
		
					$this->externalOrderBase->doLog(
						$this->constants['account_description'],
						$namespace->get('logTypeError'), 
						$result['error_msg'],
						$namespace->get('logActionImportOrder'), 
						print_r($errorArray, true)
					);
					
					continue;
				}
				
				$counter++;
				// Wenn die Anzahl der Bestellungen das Limit überschreitet
				if ($counter >= $this->constants['import_limit'])
				{
					$nextImportDate = $importOrder['order']['created'];
					break;
				}
			}
			// letztes Import Datum setzen
			$this->externalOrderBase->newImportDate($this->constants['account_name'], $nextImportDate);
			
			if ($counter)
				return $counter;
		}
	}

	/**
	 * manueller Import einer einzelnen Bestellung
	 * @param $ordernumber Kennung der Bestellung der Externen Plattform (meisten Bestellnummer)
	 * @return bool
	 */
	public function importOrderManual($ordernumber)
	{
		$namespace = Shopware()->Snippets()->getNamespace('backend/plugins/external_order_log_book/main');
		
		$result['success'] = false;
		
		if (empty($ordernumber))
		{
			return false;
		}
		
		// Bestellung befindet sich bereits im System
		if ($this->externalOrderDb->isOrderAlreadyInSystem($ordernumber))
		{
			$result['error_msg']   = $namespace->get('logMsgOrderAlreadyInSystem');
			return $result;
		}
		
		$dataOrders = $this->yategoClient->getOrder($ordernumber);
		
		if (!$dataOrders)
		{
			$result['error_msg'] = $namespace->get('logMsgGetOrder');
			return $result;
		}
		
		$dataOrders = $dataOrders[0];
		
		// Positionen holen
		$dataOrders['order_details'] = $this->yategoClient->getOrderPosition($ordernumber);
		
		$importOrder = $this->convertOrderDataForImport($dataOrders);
			
		$result = $this->externalOrderDb->importOrderInDb($importOrder);
		// Fehler beim Speichern der Bestellung
		if ($result['success'] != true)
		{
			$errorArray = array(
				'Account' => $this->constants['account_description'],
				'Bestellnummer' => $ordernumber,
				'Typ' => $namespace->get('logTypeError'),
				'Response' => $xml,
				'Array' => $dataOrders
			);

			$this->externalOrderBase->doLog(
				$this->constants['account_description'],
				$namespace->get('logTypeError'), 
				$result['error_msg'],
				$namespace->get('logActionImportOrder'), 
				print_r($errorArray, true)
			);
			
			return $result;
		}
		
		return $result;
	}

	private function convertOrderDataForImport($import)
	{
		$order = false;
		$order['internal_code']			= trim($import['Bestellnummer']);
		$order['account']				= trim($this->settings['name']);
		$order['account_description']	= trim($this->settings['description']);

		/* Allgemeine Daten */
		$order['external_order_number']	= trim($import['Bestellnummer']);
		$order['created']				= trim($import["Bestelldatum"]);
		
		$amount = 	  $this->yategoBase->getPrice($import['Gesamtumsatz'])		  // Gesamtumsatz
					+ $this->yategoBase->getPrice($import['Versandkosten'])	  // Versandkosten
					+ $this->yategoBase->getPrice($import['Nachnahmekosten'])    // Nachnahmegebühr
					+ $this->yategoBase->getPrice($import['Laenderaufschlag'])	  // Länderzuschlag
					- $this->yategoBase->getPrice($import['Gutschein'])		  // Gutschein
					- $this->yategoBase->getPrice($import['Bestellwertrabatt']); // Mengenrabatt
		
		$shipping =	  $this->yategoBase->getPrice($import['Versandkosten'])	  // Versandkosten
					+ $this->yategoBase->getPrice($import['Laenderaufschlag']);  // Länderzuschlag
		
		$order['invoice_amount']		= trim($amount);
		$order['invoice_amount_net']	= $this->externalOrderBase->getNetto($amount, $this->settings['tax_rate']);
		$order['invoice_shipping']		= trim($shipping);
		$order['invoice_shipping_net']	= $this->externalOrderBase->getNetto($shipping, $this->settings['tax_rate']);
		
		$strPaymentMethod = $import["Zahlart"];
		$order['paymentID']			= $this->yategoBase->getPaymentIdByYategoName($strPaymentMethod);
		
		$order['customercomment']	= trim($import["Bemerkungen des Kunden"]);

		$order['currency_currency']	= trim($this->settings['currency_currency']);
		$order['currency_factor']	= trim($this->settings['currency_factor']);
		
		$order['dispatchID']		= $this->settings['dispatch_id'];
		$order['subshopID']			= intval($this->settings['shop_id']);
		$order['taxID']				= intval($this->settings['tax_id']);
		$order['status']			= intval($this->settings['status']);
		$order['cleared']			= intval($this->settings['cleared']);

		$order['carrier']			= $this->settings['dispatch_carrier'];

		/* Rechnungsadresse */
		$order['billing']['customergroup']				= trim($this->settings['customergroup_key']);
		$order['billing']['salutation'] 				= $this->yategoBase->getSalutionFromYategoSalution($import["R_Anrede"]);
		$order['billing']['company']					= trim($import["R_Firma"]);
		$order['billing']['firstname']					= trim($import["R_Vorname"]);
		$order['billing']['lastname']					= trim($import["R_Nachname"]);
		$streetData	= $this->externalOrderBase->splitStreetNumber($import["R_Strasse"]);
		$order['billing']['street']						= $streetData['street'];
		$order['billing']['streetnumber']				= $streetData['streetnumber'];
		$order['billing']['additional_address_line1']	= '';
		$order['billing']['zipcode']					= trim($import["R_PLZ"]);
		$order['billing']['city']						= trim($import["R_Stadt"]);
		$order['billing']['countryID']					= $this->externalOrderBase->getCountryIdByName($import['R_Land']);
		$order['billing']['email']						= trim($import["E-Mail-Adresse"]);
		$order['billing']['phone']						= trim($import["R_Telefon"]);
		$order['billing']['fax']						= trim($import["R_Fax"]);
		$order['billing']['birthday']					= trim($import["R_Geburtsdatum"]);
		
		/* Lieferadresse */
		if(strlen(trim($import["L_Nachname"]))>0)
		{
			
			$order['shipping']['salutation'] 				= $this->yategoBase->getSalutionFromYategoSalution($import["L_Anrede"]);
			$order['shipping']['company']					= trim($import["L_Firma"]);
			$order['shipping']['firstname']					= trim($import["L_Vorname"]);
			$order['shipping']['lastname']					= trim($import["L_Nachname"]);
			$streetData	= $this->externalOrderBase->splitStreetNumber($import["L_Strasse"]);
			$order['shipping']['street']					= $streetData['street'];
			$order['shipping']['streetnumber']				= $streetData['streetnumber'];
			$order['shipping']['additional_address_line1']	= '';
			$order['shipping']['zipcode']					= trim($import["L_PLZ"]);
			$order['shipping']['city']						= trim($import["L_Stadt"]);
			$order['shipping']['countryID']					= $this->externalOrderBase->getCountryIdByName($import['L_Land']);
			$order['shipping']['phone']						= trim($import["L_Telefon"]);
			$order['shipping']['fax']						= trim($import["L_Fax"]);
		}
		else
		{
			$order['shipping']['salutation'] 				= $this->yategoBase->getSalutionFromYategoSalution($import["R_Anrede"]);
			$order['shipping']['company']					= trim($import["R_Firma"]);
			$order['shipping']['firstname']					= trim($import["R_Vorname"]);
			$order['shipping']['lastname']					= trim($import["R_Nachname"]);
			$streetData	= $this->externalOrderBase->splitStreetNumber($import["R_Strasse"]);
			$order['shipping']['street']					= $streetData['street'];
			$order['shipping']['streetnumber']				= $streetData['streetnumber'];
			$order['shipping']['additional_address_line1']	= '';
			$order['shipping']['zipcode']					= trim($import["R_PLZ"]);
			$order['shipping']['city']						= trim($import["R_Stadt"]);
			$order['shipping']['countryID']					= $this->externalOrderBase->getCountryIdByName($import['R_Land']);
			$order['shipping']['phone']						= trim($import["R_Telefon"]);
			$order['shipping']['fax']						= trim($import["R_Fax"]);
		}

		/* Artikel */
		foreach ($import["order_details"] as $detail)
		{
			$importDetail["articleordernumber"] = trim($detail['Artikelnummer']);
			$importDetail['name']				= trim($detail['Produktname']);
			$importDetail['quantity']			= intval($detail["Anzahl"]);
			$quantity = $importDetail['quantity'];
			if($quantity < 1)
				$quantity = 1;
			$price	= round($this->yategoBase->getPrice(($detail["Gesamtpreis"])) / $quantity ,2);
			$importDetail['price']				= $price;
			$importDetail['modus']				= 0;
			$importDetail['taxID']				= $this->settings['tax_id'];
			$importDetail['tax_rate']			= $this->settings['tax_rate'];
			$order['details'][] = $importDetail;
		}

		/* Nahnahmegebühr */
		if($this->yategoBase->getPrice($import['Nachnahmekosten']) > 0)
		{
			// Nahchnahme
			$importDetail["articleordernumber"]	= Shopware()->Config()->sPAYMENTSURCHARGENUMBER;
			$importDetail['name']				= Shopware()->Config()->sPAYMENTSURCHARGEADD;
			$importDetail['quantity']			= 1;
			$importDetail['price']				= $this->yategoBase->getPrice($import['Nachnahmekosten']);
			$importDetail['modus']				= 4;
			$importDetail['taxID']				= intval($this->settings['tax_id']);
			$importDetail['tax_rate']			= $this->settings['tax_rate'];
			$order['details'][] = $importDetail;
		}

		/* Gutschein */
		if($this->yategoBase->getPrice($import['Gutschein']) > 0)
		{
			$importDetail["articleordernumber"]	= "Yatego-Gutschein";
			$importDetail['name']				= Shopware()->Config()->sVOUCHERNAME;
			$importDetail['quantity']			= 1;
			$voucherValue = $this->yategoBase->getPrice($import['Gutschein']);
			if($voucherValue > 0)
				$voucherValue = $voucherValue * -1;
			$importDetail['price']				= $voucherValue;
			$importDetail['modus']				= 2;
			$importDetail['taxID']				= intval($this->settings['tax_id']);
			$importDetail['tax_rate']			= $this->settings['tax_rate'];
			$order['details'][] = $importDetail;

		}
		
		// Config
		$order['config'] = $this->settings;
		
		return $order;
	}
	
	// Check der Zugangsdaten
	public function checkAccess()
	{
		return $this->yategoClient->checkAccess();
	}
}