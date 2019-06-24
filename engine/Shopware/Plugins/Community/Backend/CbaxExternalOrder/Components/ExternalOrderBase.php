<?php
class Shopware_Components_ExternalOrderBase
{
	private $config;

	private $carrier = array(
		'amazon' => array(
			'AFL/Fedex' => 'AFL/Fedex',
			'Aramex' => 'Aramex',
			'BlueDart' => 'BlueDart',
			'Blue Package' => 'Blue Package',
			'Canada Post' => 'Canada Post',
			'Chronopost' => 'Chronopost',
			'City Link' => 'City Link',
			'DHL' => 'DHL',
			'DHL Global Mail' => 'DHL Global Mail',
			'Delhivery' => 'Delhivery',
			'Deutsche Post' => 'Deutsche Post',
			'DPD' => 'DPD',
			'DTDC' => 'DTDC',
			'Fastway' => 'Fastway',
			'FedEx' => 'FedEx',
			'FedEx SmartPost' => 'FedEx SmartPost',
			'FEDEX_JP' => 'FEDEX_JP',
			'First Flight' => 'First Flight',
			'GLS' => 'GLS',
			'GO!' => 'GO!',
			'Hermes Logistik Gruppe' => 'Hermes Logistik Gruppe',
			'India Post' => 'India Post',
			'JP_EXPRESS' => 'JP_EXPRESS',
			'Lasership' => 'Lasership',
			'La Poste' => 'La Poste',
			'Newgistics' => 'Newgistics',
			'NipponExpress' => 'NipponExpress',
			'NITTSU' => 'NITTSU',
			'OnTrac' => 'OnTrac',
			'OSM' => 'OSM',
			'Overnite Express' => 'Overnite Express',
			'Parcelforce' => 'Parcelforce',
			'Parcelnet' => 'Parcelnet',
			'Poste Italiane' => 'Poste Italiane',
			'Professional' => 'Professional',
			'Royal Mail' => 'Royal Mail',
			'SagawaExpress' => 'SagawaExpress',
			'SAGAWA' => 'SAGAWA',
			'SDA' => 'SDA',
			'Smartmail' => 'Smartmail',
			'Streamlite' => 'Streamlite',
			'Target' => 'Target',
			'TNT' => 'TNT',
			'UPS' => 'UPS',
			'UPS Mail Innovations' => 'UPS Mail Innovations',
			'USPS' => 'USPS',
			'UPSMI' => 'UPSMI',
			'YamatoTransport' => 'YamatoTransport',
			'YAMATO' => 'YAMATO',
			'Yodel' => 'Yodel',
			'Other' => 'Other'
		),
		'dawanda' => array(
			'DHL' => 'DHL',
			'DPD' => 'DPD',
			'GLS' => 'GLS',
			'UPS' => 'UPS',
			'Post' => 'Post',
			'Hermes' => 'Hermes'
		),
		'ebay' => array(
			'DHL' => 'DHL',
			'DeutschePost' => 'Deutsche Post',
			'DPD' => 'DPD',
			'FedEx' => 'FedEx',
			'GLS' => 'GLS',
			'Hermes' => 'Hermes',
			'iLoxx' => 'iLoxx',
			'Nacex' => 'Nacex',
			'UPS' => 'UPS',
			'USPS' => 'USPS',
			'Other' => 'Other'
		),
		'hood' => array(
			'DHL' => 'DHL',
			'DPD' => 'DPD',
			'GLS' => 'GLS',
			'UPS' => 'UPS',
			'Post' => 'Post',
			'Hermes' => 'Hermes'
		),
		'idealo' => array(
			'Cargo' => 'Cargo',
			'DHL' => 'DHL',
			'DPD' => 'DPD',
			'Der Courier' => 'Der Courier',
			'Deutsche Post' => 'Deutsche Post',
			'FedEx' => 'FedEx',
			'GLS' => 'GLS',
			'GO!' => 'GO!',
			'GdSK' => 'GdSK',
			'Hermes' => 'Hermes',
			'Midway' => 'Midway',
			'Noxxs Logistic' => 'Noxxs Logistic',
			'TOMBA' => 'TOMBA',
			'UPS' => 'UPS',
			'eparcel' => 'eparcel',
			'iloxx' => 'iloxx',
			'paket.ag' => 'paket.ag',
			'primeMail' => 'primeMail'
		),
		'locamo' => array(
			'DHL' => 'DHL',
			'DPD' => 'DPD',
			'GLS' => 'GLS',
			'UPS' => 'UPS',
			'Post' => 'Post',
			'Hermes' => 'Hermes'
		),
		'rakuten' => array(
			'DHL' => 'DHL',
			'DPD' => 'DPD',
			'GLS' => 'GLS',
			'UPS' => 'UPS',
			'Post' => 'Post',
			'Hermes' => 'Hermes'
		),
		'real' => array(
			'Other' => 'Other',
			'Other Hauler' => 'Other Hauler',
			'Bursped' => 'Bursped',
			'Cargoline' => 'Cargoline',
			'Computeruniverse' => 'Computeruniverse',
			'DHL' => 'DHL',
			'DHL 2 MH' => 'DHL 2 MH',
			'DHL Express' => 'DHL Express',
			'DHL Freight' => 'DHL Freight',
			'dtl' => 'dtl',
			'DPD' => 'DPD',
			'Deutsche Post' => 'Deutsche Post',
			'Dachser' => 'Dachser',
			'Marktanlieferung' => 'Marktanlieferung',
			'Emons' => 'Emons',
			'Fedex' => 'Fedex',
			'GLS' => 'GLS',
			'GEL' => 'GEL',
			'Hermes' => 'Hermes',
			'Hermes 2 MH' => 'Hermes 2 MH',
			'Hellmann' => 'Hellmann',
			'IDS Logistik' => 'IDS Logistik',
			'Iloxx' => 'Iloxx',
			'Kuehne & Nagel' => 'Kuehne & Nagel',
			'Post Italiane' => 'Post Italiane',
			'Rhenus' => 'Rhenus',
			'Schenker' => 'Schenker',
			'Spedition Guettler' => 'Spedition Guettler',
			'TNT' => 'TNT',
			'Trans FM' => 'Trans FM',
			'trans-o-flex' => 'trans-o-flex',
			'UPS' => 'UPS',
			'Zufall' => 'Zufall'
		),
		'yatego' => array(
			'DHL' => 'DHL',
			'DPD' => 'DPD',
			'GLS' => 'GLS',
			'UPS' => 'UPS',
			'Post' => 'Post',
			'Hermes' => 'Hermes'
		)
	);
	
	public function __construct($config)
    {
        $this->config = $config;
    }

    public function getCarrierStore($account)
	{
		$carriers = (array_key_exists($account, $this->carrier)) ? $this->carrier[$account] : array();

		$carrierStore = array();
		foreach ($carriers as $carrier) {
			array_push($carrierStore, array('name' => $carrier, 'description' => $carrier));
		}

		return $carrierStore;
	}
	
	/**
     * Die komplette Config des jeweiligen Account holen
     *
     * @return array
     */
	public function getAccountConfig($account)
	{
		$result = array();
		$account = strtolower($account);
		
		$table = "s_plugin_connector_".$account."_config";

		if (!$this->tableExist($table)) {
			return $result;
		}
		
		$sql = "SELECT * FROM ".$table;
		$data = Shopware()->Db()->fetchAll($sql);

		if (count($data) < 1)
			return false;
		foreach ($data as $key => $value)
		{
			$result[$data[$key]['name']] = trim($data[$key]['value']);
		}
		
		$result['tax_rate'] = $this->getTaxRateById($result['tax_id']);
		
		$shopConfig = $this->getConfigFromShop(intval($result['shop_id']));
		$result['currency_currency'] = $shopConfig['currency_currency'];
		$result['currency_factor']   = $shopConfig['currency_factor'];
		
		$accountConfig = $this->getConfigAccount($account);
		$result['name'] 		= $accountConfig['name'];
		$result['description']  = $accountConfig['description'];
		$result['plugin'] 		= $accountConfig['plugin'];
		$result['controller']   = $accountConfig['controller'];
		
		return $result;
	}

	/**
     * Neue Config Werte abspeichern
     *
     */
	public function setAccountConfig($account, $name, $value)
	{
		$account = strtolower($account);
		
		$table = "s_plugin_connector_".$account."_config";
		
		$sql = "SELECT id FROM ".$table." WHERE name = ?";
		$id = Shopware()->Db()->fetchOne($sql, array($name));

		if ($id > 0)
		{
			$sql = "UPDATE ".$table." SET name = ?, value = ? WHERE id = ?";
			Shopware()->Db()->query($sql, array($name, $value, $id));
		}
		else
		{
			$sql = "INSERT INTO ".$table."(id, name, value) VALUES(?,?,?)";
			Shopware()->Db()->query($sql, array(NULL, $name, $value));
		}
	}
	
	/**
     * Config des jeweils zugewiesenen Shop holen
     *
     * @return array
     */
	private function getConfigFromShop($shopID)
	{
 		if(strlen(trim($shopID))<1)
			 return false;
 		
		// Wenn Shopware Version kleiner 5.1.0
		if ($this->tableExist('s_core_multilanguage'))
		{
			$sql = "
			SELECT
				cu.currency AS currency_currency,
				cu.factor AS currency_factor
			FROM
				s_core_multilanguage AS cm
			LEFT JOIN
				s_core_currencies AS cu
				ON cu.id = cm.defaultcurrency
			WHERE
				cm.id = ?
			LIMIT 1";
		}
		else
		{
			$sql = "
			SELECT
				cu.currency AS currency_currency,
				cu.factor AS currency_factor
			FROM
				s_core_shops AS cs
			LEFT JOIN
				s_core_currencies AS cu
				ON cu.id = cs.currency_id
			WHERE
				cs.id = ?
			LIMIT 1";
		}
		
		$data = Shopware()->Db()->fetchRow($sql, array($shopID));

		return $data;
	}
	
	public function getAccountShippingConfig($account, $order)
	{
		$account = strtolower($account);
		
		$table = "s_plugin_connector_".$account."_config_shipping";
		
		if (!$this->tableExist($table)) {
			return false;
		}
		
		$sql = "
		SELECT
			dispatchID,
			carrier
		FROM
			".$table."
		
		WHERE
			countryID = ?
		";
		$data = Shopware()->Db()->fetchRow($sql, array($order['shipping']['countryID']));
		
		return $data;
	}
	
	public function getConfigAccount($account)
	{
		$sql = "SELECT * FROM s_plugin_externalorder_account WHERE name = ?";
		return Shopware()->Db()->fetchRow($sql, array($account));
	}
	
	/**
     * Vorname + Nachname trennen
     *
     * @return array (firstname, lastname)
     */
	public function splittName($name)
	{
		$data = explode(' ',$name);
		$count = count($data);
		if ($count < 2)
		{
			return array('firstname'=>'', 'lastname'=>trim($name));
		}
		$result['lastname'] = trim($data[$count-1]);
		for($i=0; $i < $count-1; $i++)
		{
			if ($i > 0)
				$result['firstname'].= ' ';
			
			$result['firstname'] .= trim($data[$i]);
		}
		return $result;

	}
	
	/**
     * Straße + Nummer trennen
     *
     * @return array (street, streetnumber)
     */
	public function splitStreetNumber($input)
	{
		$input = trim($input);
		if(strlen($input)<1)
			return false;
		$bNumber = false;
		$street = '';
		$number = '';
		for($i=0;$i<strlen(trim($input));$i++)
		{
			$z = $input[$i];
			if(intval($z)>0)
				$bNumber = true;
			if(!$bNumber)
				$street.=$z;
			else
				$number.=$z;
		}
		
		if (empty($street))
		{
			$street = $number;
			$number = '';
		}
		return array('street'=>trim($street), 'streetnumber'=>trim($number));
	}
	
	public function strToCsvData($input, $delimiter=',', $enclosure='"', $escape=null, $eol=null)
	{
		$temp=fopen("php://memory", "rw");
		fwrite($temp, $input);
		fseek($temp, 0);
		$r = array();
		while (($data = fgetcsv($temp, 4096, $delimiter, $enclosure)) !== false)
		{
			$r[] = $data;
		}
		fclose($temp);
		return $r;
	}

	public function getCsvDataAsKeyArray($data, $rowDelimiter, $colDelimiter, $enclosure, $escape)
	{
		$result = false;
		$csv = $this->strToCsvData($data, $colDelimiter, $enclosure, $escape, $rowDelimiter);
		if(count($csv)<2)
			return false;
		$header = $csv[0];
		for($i=1;$i<count($csv);$i++)
		{
			$arr = array();
			for($j = 0;$j<count($csv[$i]);$j++)
			{
				if((strlen(trim($csv[$i][$j]))>0) && (strlen(trim($header[$j]))>0))
				{
					$arr[$header[$j]] = trim($csv[$i][$j]);
				}
			}
			$result[] = $arr;
		}
		return  $result;
	}
	
	/**
     * Country ID durch Übergabe des Ländername holen
     *
     * @return double (countryID)
     */
	public function getCountryIdByName($name)
	{
		$sql = "SELECT id FROM s_core_countries WHERE UPPER(countryname) LIKE ? LIMIT 1";
		$countryID = doubleval(Shopware()->Db()->fetchOne($sql, array(trim(strtoupper($name)))));

		if(!empty($countryID))
		{
			return $countryID;
		}
	}
	
	/**
     * Country ID durch Übergabe des ISO Codes holen
     *
     * @return double (countryID)
     */
	public function getCountryIdByISO($iso)
	{
		$sql = "SELECT id FROM s_core_countries WHERE countryiso = ?";
		$countryID = doubleval(Shopware()->Db()->fetchOne($sql, array(trim(strtoupper($iso)))));
		
		if(!empty($countryID))
		{
			return $countryID;
		}
	}
	
	public function getNetto($brutto, $taxpercent)
	{
		$b = doubleval($brutto);
		$p = doubleval($taxpercent);
		if($p<=0)
			return $b;
		return (($b)/(1+($p/100)));
	}
	
	public function getTaxRateById($taxID)
	{
		$taxID = intval($taxID);
		
		$sql = "SELECT tax FROM s_core_tax WHERE id = ?";
		$tax = doubleval(Shopware()->Db()->fetchOne($sql, array($taxID)));

		return $tax;
	}
	
	public function getTaxRateByConditions($order, $taxID = '')
    {
		$taxID 			= ($taxID) ? $taxID : $order['config']['tax_id'];
		$countryID 		= $order['shipping']['countryID'];
		$customergroup 	= $order['billing']['customergroup'];

		$sql = "SELECT * FROM s_core_customergroups WHERE groupkey = ?";
		$customergroupID = Shopware()->Db()->fetchOne($sql, array($customergroup));
		
        $sql = "
        SELECT
			id,
			tax
		FROM
			s_core_tax_rules
		WHERE
            active = 1 AND groupID = ?
        AND
            (countryID = ? OR countryID IS NULL)
        AND
            (customer_groupID = ? OR customer_groupID = 0 OR customer_groupID IS NULL)
			
        ORDER BY customer_groupID DESC, areaID DESC, countryID DESC, stateID DESC
        LIMIT 1
        ";

        $getTax = Shopware()->Db()->fetchRow($sql, array($taxID, $countryID, $customergroupID));
		
        if (empty($getTax["id"]))
		{
            $sql = "SELECT tax FROM s_core_tax WHERE id = ?";
			$getTax["tax"] = doubleval(Shopware()->Db()->fetchOne($sql, array($taxID)));
        }
		
		$tax = $getTax["tax"];
		
		return $tax;
    }
	
	/**
	 * Holt die errechneten Netto Versandkosten
	 * @param $order-array
	 * @return string - Netto Versandkosten
	 */
	public function getInvoiceShippingNetto($order)
    {
		$sql = "SELECT tax_calculation FROM s_premium_dispatch WHERE id = ?";
		$tax_calculation = Shopware()->Db()->fetchOne($sql, array($order['dispatchID']));
		
		if ($tax_calculation < 1)
		{
			$tax_rate = $this->getMaxTax($order['external_order_number']);
		}
		else
		{
			$sql = "SELECT tax FROM s_core_tax WHERE id = ?";
			$tax_rate = Shopware()->Db()->fetchOne($sql, array($tax_calculation));
		}
		
		$invoice_shipping_net = $this->getNetto($order['invoice_shipping'], $tax_rate);
		
		return $invoice_shipping_net;
    }
	
	/**
	 * Holt den höchsten MwSt Satz der einzelnen Artikel
	 * @param $external_order_number - externe Bestellnummer
	 * @return double - max_tax
	 */
	public function getMaxTax($external_order_number)
    {
		$sql = "
        SELECT
			MAX(tax_rate) as max_tax
		FROM
			s_plugin_externalorder_order_details
		WHERE
            external_order_number = ?
        AND
            modus = 0
			
        GROUP BY external_order_number
        ";
		
		$maxTax = Shopware()->Db()->fetchOne($sql, array($external_order_number));
		
		return $maxTax;
    }
	
	public function xmlNodeToString($value)
	{
		return trim((string)$value);
	}
	
	public function xmlNodeToInt($value)
	{
		return (int)trim($value);
	}

	public function xmlNodeToDouble($value)
	{
		return (double)trim($value);
	}
	
	/**
     * Das neue Importdatum speichern bzw. das Datum des letzten Import
     *
     */
	public function newImportDate($account, $nextImportDate = '')
	{
		if ($nextImportDate) {
			$split = explode(' ', $nextImportDate);
			$current_date = $split[0]; // current date
			$current_time = $split[1]; // current time
		} else {
			$current_date = date("Y-m-d"); // current date
			$current_time = date("H:i"); // current time
		}
		$this->setAccountConfig($account, 'last_import_date', $current_date);
		$this->setAccountConfig($account, 'last_import_time', $current_time);
	}
	
	/**
     * Versandart holen
     *
     * @return int (ID der Versandart)
     */
	public function getDispatch($config, $order)
	{
		$countryID = $order['shipping']['countryID'];
		$paymentID = $order['paymentID'];
		
		$sql = "
		SELECT 
			id,
			name,
			comment
		FROM
			s_premium_dispatch AS pd,
			s_premium_dispatch_countries AS pdc,
			s_premium_dispatch_paymentmeans AS pdp
		
		WHERE
			pd.id = pdc.dispatchID
		AND
			pd.id = pdp.dispatchID
		AND
			pdc.countryID = ?
		AND
			pdp.paymentID = ?";
		$dispatches = Shopware()->Db()->fetchAll($sql, array($countryID, $paymentID));
		
		// Wenn mehr als eine Versandart, dann die zugewiesene Standardzahlungsart nehmen
		if (count($dispatches) > 1)
		{
			foreach ($dispatches as $dispatch)
			{
				if ($dispatch['id'] == $config['dispatch_id'])
				{
					$dispatchID = $config['dispatch_id'];
					break;
				}
				else
				{
					$dispatchID = $dispatch['id'];
				}
			}
		}
		else
		{
			$dispatchID = $dispatches[0]['id'];
		}

		if (!empty($dispatchID))
		{
			return intval($dispatchID);
		}
	}
	
	/**
     * Artikel holen
     *
     * @return array
     */
	public function getArticle($order, $ordernumber, $originalArticleName = 'Unknown')
	{
		$sql = "
		SELECT 
			a.name, 
			a.configurator_set_id,
			a.taxID,
			ad.id AS articleDetailsID,
			t.tax AS tax_rate
        FROM 
			s_articles AS a
		
		JOIN s_articles_details AS ad
		ON ad.articleID = a.id
			
		JOIN s_core_tax AS t
		ON t.id = a.taxID
		
		WHERE
			ad.ordernumber = ?
		";
		$article = Shopware()->Db()->fetchRow($sql, trim($ordernumber));
		
		if ($article['name'])
		{
			if ($article['configurator_set_id'])
			{
				$article['name'] = $article['name'].' '.$this->getAdditionalText($article['articleDetailsID']);
			}
			
			$article['tax_rate'] 	= $this->getTaxRateByConditions($order, $article['taxID']);
		}
		else
		{
			// wenn Artikel nicht in der Datenbank - original Artikelname und Standard Tax übergeben
			$article['name'] 		= trim($originalArticleName);
			$article['taxID'] 		= $order['config']['tax_id'];
			$article['tax_rate'] 	= $this->getTaxRateByConditions($order);
		}
		
		return $article;
	}
	
	/**
     * Varianten Bezeichnung holen
     *
     * @return string
     */
	private function getAdditionalText($articleDetailsID)
	{
		$sql = "
		SELECT
			GROUP_CONCAT(o.name SEPARATOR ' ') as additionaltext
		FROM
			s_articles_details a
			
		JOIN s_article_configurator_option_relations r
		ON r.article_id = a.id
		
		JOIN s_article_configurator_options o
		ON o.id = r.option_id
		
		WHERE a.id = ?
		
		GROUP BY a.id
		";
		
		return Shopware()->Db()->fetchOne($sql, array($articleDetailsID));
	}
	
	public function getUrlencode($value)
	{
		return str_replace("%7E", "~", rawurlencode($value));
    }
	
	/**
     * Summen von Cent in EUR umrechnen
     *
     * @return string
     */
	public function getCentToEur($sum)
    {
		return $sum / 100;
    }
	
	public function getDouble($value)
	{
		return doubleval(str_replace(',','.',$value));
	}
	
	/**
     * Überprüfung ob Tabelle existiert
     *
	 * @return bool
     */
	public function tableExist($tableName)
    {
        $sql = "SHOW TABLES LIKE '" . $tableName . "'";
        $result = Shopware()->Db()->fetchRow($sql);
        return !empty($result);
    }
	
	/**
	 * Internal helper function to check if a database table column exist.
	 *
	 * @param string $tableName
	 * @param string $columnName
	 *
	 * @return bool
	 */
	public function columnExist($tableName, $columnName)
	{
		$sql = "SHOW COLUMNS FROM " . $tableName . " LIKE ?";

		return Shopware()->Db()->query($sql, array($columnName))->rowCount() > 0;
	}
	
	public static function splitStreetNumberRegEx($address)
    {
        $regex = '
           /\A\s*
           (?: #########################################################################
               # Option A: [<Addition to address 1>] <House number> <Street name>      #
               # [<Addition to address 2>]                                             #
               #########################################################################
               (?:(?P<A_Addition_to_address_1>.*?),\s*)? # Addition to address 1
           (?:No\.\s*)?
               (?P<A_House_number>\pN+[a-zA-Z]?(?:\s*[-\/\pP]\s*\pN+[a-zA-Z]?)*) # House number
           \s*,?\s*
               (?P<A_Street_name>(?:[a-zA-Z]\s*|\pN\pL{2,}\s\pL)\S[^,#]*?(?<!\s)) # Street name
           \s*(?:(?:[,\/]|(?=\#))\s*(?!\s*No\.)
               (?P<A_Addition_to_address_2>(?!\s).*?))? # Addition to address 2
           |   #########################################################################
               # Option B: [<Addition to address 1>] <Street name> <House number>      #
               # [<Addition to address 2>]                                             #
               #########################################################################
               (?:(?P<B_Addition_to_address_1>.*?),\s*(?=.*[,\/]))? # Addition to address 1
               (?!\s*No\.)(?P<B_Street_name>\S\s*\S(?:[^,#](?!\b\pN+\s))*?(?<!\s)) # Street name
           \s*[\/,]?\s*(?:\sNo\.)?\s+
               (?P<B_House_number>\pN+\s*-?[a-zA-Z]?(?:\s*[-\/\pP]?\s*\pN+(?:\s*[\-a-zA-Z])?)*|
               [IVXLCDM]+(?!.*\b\pN+\b))(?<!\s) # House number
           \s*(?:(?:[,\/]|(?=\#)|\s)\s*(?!\s*No\.)\s*
               (?P<B_Addition_to_address_2>(?!\s).*?))? # Addition to address 2
           )
           \s*\Z/x';
        $result = preg_match($regex, $address, $matches);
        if ($result === 0) {
            $result = preg_match('/(?P<streetNumber>\d+[ ]{0,1}\D{0,1})$/', $address, $matches);
            if ($result !== 0) {
                $matches['streetName'] = rtrim($address, $matches['streetNumber']);
                $matches['streetNumber'] = trim($matches['streetNumber']);
                return array(
                    'additionToAddress1' => '',
                    'streetName' => $matches['streetName'],
                    'houseNumber' => $matches['streetNumber'],
                    'additionToAddress2' => ''
                );
            }
			// Update MB
			return array(
				'additionToAddress1' => '',
				'streetName' => $address,
				'houseNumber' => $matches['streetNumber'],
				'additionToAddress2' => ''
			);
            //throw new \InvalidArgumentException(sprintf('Address \'%s\' could not be splitted into street name and house number', $address));
        } elseif ($result === false) {
			// Update MB
			return array(
				'additionToAddress1' => '',
				'streetName' => $address,
				'houseNumber' => $matches['streetNumber'],
				'additionToAddress2' => ''
			);
            //throw new \RuntimeException(sprintf('Error occurred while trying to split address \'%s\'', $address));
        }
        if (!empty($matches['A_Street_name'])) {
            return array(
                'additionToAddress1' => $matches['A_Addition_to_address_1'],
                'streetName' => $matches['A_Street_name'],
                'houseNumber' => $matches['A_House_number'],
                'additionToAddress2' => (isset($matches['A_Addition_to_address_2'])) ? $matches['A_Addition_to_address_2'] : ''
            );
        } else {
            return array(
                'additionToAddress1' => $matches['B_Addition_to_address_1'],
                'streetName' => $matches['B_Street_name'],
                'houseNumber' => $matches['B_House_number'],
                'additionToAddress2' => isset($matches['B_Addition_to_address_2']) ? $matches['B_Addition_to_address_2'] : ''
            );
        }
    }
	
	public function splitAddress($address)
	{
		$address = trim($address);
		
		$streetCount = strlen($address);
		
		$streetData = $this->splitStreetNumberRegEx($address);
		
		$streetCheck = strlen(trim($streetData['streetName'].' '.$streetData['houseNumber'].' '.$streetData['additionToAddress2']));
		
		// Überprüfen ob die neue Funktion zum Splitten der Straße wieder ein paar Zeichen verschluckt hat, dann die alte nehmen
		if ($streetCount != $streetCheck)
		{
			$streetDataNew = $this->splitStreetNumber($address);
			
			return array(
                'streetName' => $streetDataNew['street'],
                'houseNumber' => $streetDataNew['streetnumber']
            );
		}
		
		return $streetData;
	}
	
	/**
     * Meldungen in Log speichern und bei hinterlegter E-Mail auch per Mail versenden
     *
     */
	public function doLog($account, $type, $msg, $action, $debugData = null)
	{
		if ($type == 'Fehler' || $type == 'Error')
		{
			$sql = "
				SELECT
					id
				FROM
					s_plugin_externalorder_log
				WHERE
					account = ?
				AND
					type = ?
				AND
					msg = ?
				AND
					action = ?
				AND
					debugdata = ?";
			$logData = Shopware()->Db()->fetchOne($sql, array(trim($account), trim($type), trim($msg), trim($action), trim($debugData)));
			
			if (!$logData)
			{
				$sql = "
				INSERT INTO s_plugin_externalorder_log
				(id, account, date, type, msg, action, debugdata)
				VALUES(?,?,now(),?,?,?,?)";
				Shopware()->Db()->query($sql, array(null, trim($account), trim($type), trim($msg), trim($action), trim($debugData)));
				
				// Mail senden
				if ($this->config->email)
				{
					$this->sendMail('PluginExternalOrderLog', $account, $type, $msg, $action, $debugData);
				}
			}
		}
		else
		{
			$sql = "
			INSERT INTO s_plugin_externalorder_log
			(id, account, date, type, msg, action, debugdata)
			VALUES(?,?,now(),?,?,?,?)";
			Shopware()->Db()->query($sql, array(null, trim($account), trim($type), trim($msg), trim($action), trim($debugData)));
		}
	}
	
	/**
     * Meldungen per Mail versenden
     *
     */
	private function sendMail($template, $account, $type, $msg, $action, $debugData)
	{
		$context = array();
		
		$context['account'] 	= $account;
		$context['type'] 		= $type;
		$context['msg'] 		= $msg;
		$context['action'] 		= $action;
		if ($this->config->debug)
		{
			$context['debugData'] 	= $debugData;
		}

        $mail = Shopware()->TemplateMail()->createMail($template, $context);
        $mail->addTo($this->config->email);
        $mail->send();
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