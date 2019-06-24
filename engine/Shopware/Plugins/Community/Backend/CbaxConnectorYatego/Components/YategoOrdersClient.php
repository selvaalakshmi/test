<?php
class Shopware_Components_YategoOrdersClient
{
	private $constants;
	
	private $settings;

	protected $proxy;
	
	/** @var Shopware_Components_ExternalOrderBase */
	private $externalOrderBase;
	
	/** @var Shopware_Components_ExternalOrderDb */
	private $externalOrderDb;

	public function __construct($constants, $settings)
	{
		$this->externalOrderBase 	= Shopware()->ExternalOrderBase();
		$this->externalOrderDb 		= Shopware()->ExternalOrderDb();
		
		$this->constants 	= $constants;
        $this->settings 	= $settings;
		$this->proxy		= Shopware()->Plugins()->Backend()->CbaxExternalOrder()->Config()->proxy;
	}
	
	/**
	 * Alle Bestellungen holen
	 * @return xml mit allen Bestellungen
	 */
	public function getOrders()
	{
		$namespace = Shopware()->Snippets()->getNamespace('backend/plugins/external_order_log_book/main');
		
		$url	= trim($this->settings['url']);
		$user	= trim($this->settings['user']);
		$pass	= trim($this->settings['pass']);
		
		$urlOrders .= $url.'?user='.urlencode($user).'&passwd='.urlencode($pass).'&action=csv_order';
		$urlOrders .= '&von='.urlencode(trim($this->getFormattedLastTimestamp()));
		$urlOrders .= '&bis='.urlencode(trim($this->getFormattedTimestamp()));
		
		$ordersData = utf8_encode(file_get_contents($urlOrders));
		
		$dataOrders = $this->externalOrderBase->getCsvDataAsKeyArray($ordersData,"\n",";",'"','\\');
		
		if ($dataOrders)
		{
			return $dataOrders;
		}
		else
		{
			$errorArray = array(
				'Account' => $this->constants['account_description'],
				'Typ' => $namespace->get('logTypeError'),
				'Request' => $urlOrders,
				'Response' => $dataOrders
			);
			
			$this->externalOrderBase->doLog(
				$this->constants['account_description'], 
				$namespace->get('logTypeError'), 
				$namespace->get('logMsgGetOrder'), 
				$namespace->get('logActionGetOrder'), 
				print_r($errorArray, true)
			);
		}
	}
	
	/**
	 * Einzelne Bestellung per Bestellnummer holen
	 * @param string $ordernumber
	 * @return xml mit einer Bestellungen
	 */
	public function getOrder($ordernumber)
	{
		$namespace = Shopware()->Snippets()->getNamespace('backend/plugins/external_order_log_book/main');
		
		$url	= trim($this->settings['url']);
		$user	= trim($this->settings['user']);
		$pass	= trim($this->settings['pass']);
		
		$urlOrders .= $url.'?user='.urlencode($user).'&passwd='.urlencode($pass).'&action=csv_order';
		$urlOrders .= '&von='.urlencode(trim($ordernumber));
		$urlOrders .= '&bis='.urlencode(trim($ordernumber));
		
		$ordersData = utf8_encode(file_get_contents($urlOrders));
		
		$dataOrders = $this->externalOrderBase->getCsvDataAsKeyArray($ordersData,"\n",";",'"','\\');
		
		if ($dataOrders)
		{
			return $dataOrders;
		}
		else
		{
			$errorArray = array(
				'Account' => $this->constants['account_description'],
				'Bestellnummer' => $ordernumber,
				'Typ' => $namespace->get('logTypeError'),
				'Request' => $urlOrders,
				'Response' => $dataOrders
			);
			
			$this->externalOrderBase->doLog(
				$this->constants['account_description'], 
				$namespace->get('logTypeError'), 
				$namespace->get('logMsgGetOrder'), 
				$namespace->get('logActionGetOrder'), 
				print_r($errorArray, true)
			);
		}
	}
	
	/**
	 * Die Artikel einer Bestellung holen
	 * @param string $ordernumber
	 * @return xml mit einer Bestellungen
	 */
	public function getOrderPosition($ordernumber)
	{
		$namespace = Shopware()->Snippets()->getNamespace('backend/plugins/external_order_log_book/main');
		
		$url	= trim($this->settings['url']);
		$user	= trim($this->settings['user']);
		$pass	= trim($this->settings['pass']);
		
		$urlPos	.= $url.'?user='.urlencode($user).'&passwd='.urlencode($pass).'&action=csv_products';
		$urlPos	.= '&von='.urlencode(trim($ordernumber));
		$urlPos	.= '&bis='.urlencode(trim($ordernumber));
		
		$posData = utf8_encode(file_get_contents($urlPos));
		
		$dataDetails = $this->externalOrderBase->getCsvDataAsKeyArray($posData,"\n",";",'"','\\');
		
		$articles = '';
		foreach($dataDetails as $article)
		{
			$articles[] = $article;
		}
		
		if ($articles)
		{
			return $articles;
		}
		else
		{
			$errorArray = array(
				'Account' => $this->constants['account_description'],
				'Bestellnummer' => $ordernumber,
				'Typ' => $namespace->get('logTypeError'),
				'Request' => $urlPos,
				'Response' => $dataOrders
			);
			
			$this->externalOrderBase->doLog(
				$this->constants['account_description'], 
				$namespace->get('logTypeError'), 
				$namespace->get('logMsgGetOrder'), 
				$namespace->get('logActionGetOrder'), 
				print_r($errorArray, true)
			);
		}
	}
	
	public function getFormattedTimestamp()
    {
        return date("d.m.Y");
    }
	
	public function getFormattedLastTimestamp()
    {
		$date = explode('-', $this->settings["last_import_date"]);
		$time = explode(':', $this->settings["last_import_time"]);
		
		$year		= $date[0];
    	$month		= $date[1];
    	$day		= $date[2];
		$hour		= $time[0];
    	$minute		= $time[1];
		
		// Importzeit - x Minuten (frequency), um auch alle noch bis dahin nicht abgeschlossenen Bestellungen zu holen
		return date("d.m.Y", mktime($hour, $minute - $this->constants['frequency'], 0, $month, $day, $year));
    }
	
	/**
	 * Check der Zugangsdaten
	 * @return xml Nachricht
	 */
	public function checkAccess()
	{
		$namespace = Shopware()->Snippets()->getNamespace('backend/plugins/external_order_log_book/main');
		
		$url	= trim($this->settings['url']);
		$user	= trim($this->settings['user']);
		$pass	= trim($this->settings['pass']);
		
		$urlOrders	= $url.'?user='.urlencode($user).'&passwd='.urlencode($pass).'&action=csv_order';
		
		$urlOrders	.= '&von='.urlencode(trim($this->getFormattedLastTimestamp()));
		$urlOrders	.= '&bis='.urlencode(trim($this->getFormattedTimestamp()));
		
		$ordersData = utf8_encode(file_get_contents($urlOrders));
		
		if (!empty($ordersData))
		{
			$result['success'] = true;
		}
		else
		{
			$result['success'] = false;
			$result['message'] = trim('Bitte überprüfen Sie Ihre Zugangsdaten!');
			
			$errorArray = array(
				'Account' => $this->constants['account_description'],
				'Typ' => $namespace->get('logTypeError'),
				'Request' => $urlOrders,
				'Response' => $ordersData
			);
			
			$this->externalOrderBase->doLog(
				$this->constants['account_description'], 
				$namespace->get('logTypeError'), 
				$namespace->get('logMsgCheckAccess'), 
				$namespace->get('logActionCheckAccess'), 
				print_r($errorArray, true)
			);
		}
		
		return $result;
	}
}