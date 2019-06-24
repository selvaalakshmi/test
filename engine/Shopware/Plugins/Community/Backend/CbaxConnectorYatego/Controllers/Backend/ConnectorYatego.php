<?php
class Shopware_Controllers_Backend_ConnectorYatego extends Shopware_Controllers_Backend_ExtJs
{
	private $plugin;
	
	private $yategoConnector;
	
	public function init()
	{
		$this->yategoConnector 	= Shopware()->YategoOrdersConnector();
		$this->plugin 			= Shopware()->Plugins()->Backend()->CbaxConnectorYatego();
		
		$this->View()->addTemplateDir(dirname(__FILE__) . "/../../Views/");
        parent::init();
	}

	public function indexAction()
	{
		$this->View()->loadTemplate("backend/connector_yatego/app.js");
	}
	
	public function checkAccessAction()
	{
		$access = $this->yategoConnector->checkAccess();
		
		if ($access['success'])
		{
			$this->View()->assign(array('success' => true));
		}
		else
		{
			$this->View()->assign(array('success' => false, 'message' => $access['message']));
		}
	}
	
	private function getConfigForAccount()
	{
		$sql = "
		SELECT
			*
		FROM
			s_plugin_connector_yatego_config
		";
		$data = Shopware()->Db()->fetchAll($sql);
		
		if(count($data)<1)
			return false;
		
		foreach ($data as $key => $value)
		{
			$res[$data[$key]['name']] = trim($data[$key]['value']);
		}
		
		$res['status'] = intval($res['status']);
		$res['cleared'] = intval($res['cleared']);
		
		return $res;
	}

	private function setConfigEntry($name, $value)
	{
		$sql = "
		SELECT
			id
		FROM
			s_plugin_connector_yatego_config
		WHERE
			name = ?";
		$id = Shopware()->Db()->fetchOne($sql, array($name));
		
		if($id > 0)
		{
			$sql = "UPDATE s_plugin_connector_yatego_config SET name = ?, value = ? WHERE id = ?";
			Shopware()->Db()->query($sql, array($name, $value, $id));
		}
		else
		{
			$sql = "INSERT INTO s_plugin_connector_yatego_config(id, name, value) VALUES(null,?,?)";
			Shopware()->Db()->query($sql, array($name, $value));
		}
	}

	public function saveConfigAction()
	{
		$request = $this->Request();
		$config['user']								= trim($request->getParam('user',''));
		$config['pass']								= trim($request->getParam('pass',''));
		$config['url']								= trim($request->getParam('url',''));
		$config['shop_id']							= intval($request->getParam('shop_id',-1));
		$config['tax_id']							= intval($request->getParam('tax_id',-1));
		$config['dispatch_id']						= intval($request->getParam('dispatch_id',-1));
		$config['dispatch_carrier']					= trim($request->getParam('dispatch_carrier',''));
		$config['customergroup_key']				= trim($request->getParam('customergroup_key',''));
		$config['last_import_date']					= trim($request->getParam('last_import_date'));
		$config['last_import_time']					= trim($request->getParam('last_import_time'));
		$config['status']							= intval($request->getParam('status',-1));
		$config['cleared']							= intval($request->getParam('cleared',-1));
		$config['payment_vorauskasse_id']			= intval($request->getParam('payment_vorauskasse_id',-1));
		$config['payment_barzahlung_id']			= intval($request->getParam('payment_barzahlung_id',-1));
		$config['payment_nachnahme_id']				= intval($request->getParam('payment_nachnahme_id',-1));
		$config['payment_kreditkarte_id']			= intval($request->getParam('payment_kreditkarte_id',-1));
		$config['payment_sofortueberweisung_id']	= intval($request->getParam('payment_sofortueberweisung_id',-1));
		$config['payment_paypal_id']				= intval($request->getParam('payment_paypal_id',-1));
		$config['payment_rechnung_id']				= intval($request->getParam('payment_rechnung_id',-1));
		
		foreach($config as $key => $value)
		{
			$this->setConfigEntry($key, $value);
		}
		
		$this->View()->assign(array('success' => true));
	}

	public function loadConfigAction()
	{
		$data = $this->getConfigForAccount();

		$this->View()->assign(array('success' => true, 'data' => $data));
	}
}