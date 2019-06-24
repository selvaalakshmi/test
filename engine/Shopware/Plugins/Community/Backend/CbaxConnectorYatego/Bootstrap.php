<?php

require_once __DIR__ . '/Components/CSRFWhitelistAware.php';

class Shopware_Plugins_Backend_CbaxConnectorYatego_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
	protected $constants;
	
	protected $settings;
	
	public function getInfo()
    {
		return array(
    		'version' => $this->getVersion(),
			'label' => $this->getLabel(),
			'autor' => 'Coolbax',
			'copyright' => 'Copyright © 2015, Coolbax',
			'description' => file_get_contents($this->Path() . 'info.txt'),
			'license' => 'Spezial-Lizenz',
			'support' => 'http://www.coolbax.de',
			'link' => 'http://www.coolbax.de'
    	);
    }
	
	public function getLabel()
    {
        return 'Connector Bestellimport Yatego';
    }
	
	public function getVersion()
    {
        return '2.3.7';
    }
	
	public function enable()
    {
		return array(
            'success' => true,
            'invalidateCache' => array('backend')
        );
    }
	
	/**
	 * After init event of the bootstrap class.
	 *
	 * The afterInit function registers the custom plugin models.
	 */
	public function afterInit()
	{
		$this->constants	= $this->loadConstants();
		try {
			$this->settings 	= Shopware()->ExternalOrderBase()->getAccountConfig($this->constants['account_name']);
		} catch (Exception $e) {
		}
		
		parent::afterInit();
	}
	
	public function install()
	{
		$this->createForm();
		$this->createEvents();
		$this->createCronJobs();
		$this->createMyTranslations();
		$this->createDatabaseTables();
		$this->updateSnippets();
		$this->cleanUpFiles();
		return true;
	}
	
	public function update($oldVersion)
	{
		switch ($oldVersion) {
			case '2.2.0':
			case '2.2.1':
			case '2.2.2':
			case '2.2.3':
			case '2.2.4':
			case '2.2.5':
			case '2.2.6':
			case '2.2.7':
				$this->removeElement('cron_key');
			case '2.2.8':
			case '2.2.9':
			case '2.3.0':
			case '2.3.1':
			case '2.3.2':
			case '2.3.3':
			case '2.3.4':
			case '2.3.6':
				break;
			default:
				//Die installierte Version entspricht keiner hier aufgeführten Version
				//Aus diesem Grund wird dem Plugin-Manaager mitgeteilt, 
				//dass das Update fehlgeschlagen ist.
				//return false;
		}
		
		$this->createForm();
		$this->createEvents();
		$this->updateSnippets();
		$this->cleanUpFiles();
		
		return array(
            'success' => true,
            'invalidateCache' => array('backend')
        );
	}
	
	public function uninstall()
    {
		$sql = "DELETE FROM s_plugin_externalorder_account WHERE name = ?";
		Shopware()->Db()->query($sql, array($this->constants['account_name']));
		
        return true;
    }

	protected function createForm()
    {
        $form = $this->Form();
		$parent = $this->Forms()->findOneBy(array('name' => 'Interface'));
        $form->setParent($parent);
		$checkExternalOrderUrl = Shopware()->Front()->Router()->assemble(array(
			'controller' => 'ConnectorYategoCheck', 
			'action' => 'checkExternalOrder',
			'module' => 'backend', 
		));
		$form->setElement('button', 'settings', array(
			'label' => 'Einstellungen aufrufen',
			'handler' => 'function(btn) {
				Ext.Ajax.request({
					scope:this,
					url: "' . $checkExternalOrderUrl . '",
					success: function(result,request) {
						var jsonData = Ext.JSON.decode(result.responseText);
						if (jsonData.success === true)
						{
							openNewModule("Shopware.apps.ConnectorYatego");
						}
						else
						{
							Ext.MessageBox.alert(\'Warnung\', jsonData.message);
						}
					},
					failure: function(result,request) {
						var jsonData = Ext.JSON.decode(result.responseText);
						Ext.MessageBox.alert(\'Warnung\', jsonData.message);
					}
				});
			}'
		));
    }
	
	protected function createEvents()
    {
        $this->registerController('Backend', 'ConnectorYatego');
		
		$this->registerController('Backend', 'ConnectorYategoApi');
		
		$this->registerController('Backend', 'ConnectorYategoCheck');
		
		$this->subscribeEvent(
	 		'Enlight_Bootstrap_InitResource_YategoOrdersBase',
	 		'onInitResourceYategoOrdersBase'
	 	);
		
		$this->subscribeEvent(
	 		'Enlight_Bootstrap_InitResource_YategoOrdersClient',
	 		'onInitResourceYategoOrdersClient'
	 	);
		
		$this->subscribeEvent(
	 		'Enlight_Bootstrap_InitResource_YategoOrdersConnector',
	 		'onInitResourceYategoOrdersConnector'
	 	);
    }
	
	private function createCronJobs()
	{
		$this->subscribeEvent(
			'Shopware_CronJob_CbaxConnectorYategoImportOrder',
			'onRunImportOrder'
		);
		
		$this->createCronJob(
			'Yatego Bestellungen importieren',
			'CbaxConnectorYategoImportOrder',
			3600,
			true
		);
	}
	
	protected function createMyTranslations()
    {
        $form = $this->Form();
        $translations = array(
            'en_GB' => array(
				'settings' => array('label' => 'Show settings')
            )
        );
        $shopRepository = Shopware()->Models()->getRepository('\Shopware\Models\Shop\Locale');
        foreach($translations as $locale => $snippets) {
			$localeModel = $shopRepository->findOneBy(array(
				'locale' => $locale
			));

			if($localeModel === null){
				continue;
			}

			foreach($snippets as $element => $snippet) {
				$elementModel = $form->getElement($element);
				if($elementModel === null) {
					continue;
				}
				$translationModel = new \Shopware\Models\Config\ElementTranslation();
				if (array_key_exists('label', $snippet)) {
					$translationModel->setLabel($snippet['label']);
				}
				if (array_key_exists('description', $snippet)) {
					$translationModel->setDescription($snippet['description']);
				}
				$translationModel->setLocale($localeModel);
				$elementModel->addTranslation($translationModel);
			}
		}
    }
	
	private function createDatabaseTables()
	{
		$sql = "CREATE TABLE IF NOT EXISTS `s_plugin_connector_yatego_config` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(255) NOT NULL,
					`value` text NOT NULL,
					PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";
		Shopware()->Db()->query($sql);
		
		// Nur zur Sicherheit, falls erst der Connector und dann die externen Bestellungen installiert wird
		$sql = "CREATE TABLE IF NOT EXISTS `s_plugin_externalorder_account` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(100) NOT NULL,
					`description` varchar(100) NOT NULL,
					`plugin` varchar(100) NOT NULL,
					`controller` varchar(100) NOT NULL,
					PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";
		Shopware()->Db()->query($sql);
		
		$sql = "SELECT id FROM s_plugin_externalorder_account WHERE name = ?";
		$result = Shopware()->Db()->fetchOne($sql, array($this->constants['account_name']));
		if (empty($result))
		{
			$sql = "INSERT INTO s_plugin_externalorder_account (id, name, description, plugin, controller) VALUES (?,?,?,?,?)";
			Shopware()->Db()->query($sql, array(NULL, $this->constants['account_name'], $this->constants['account_description'], $this->constants['account_plugin'], $this->constants['account_controller']));
		}
		
		$sql = "INSERT IGNORE INTO s_plugin_connector_yatego_config (id, name, value) VALUES 
			(1, 'url', 'http://www1.yatego.com/admin/modules/yatego/orders.php'),
			(2, 'last_import_date', '".date("Y-m-d")."'),
			(3, 'last_import_time', '".date("H:i")."');";
		Shopware()->Db()->query($sql);
	}

	public function removeElement($name)
	{
		try {
			$sql = "SELECT `id` FROM `s_core_config_forms` WHERE `name` = 'CbaxConnectorYatego'";
			$formID = Shopware()->Db()->fetchOne($sql);

			$delete = 'DELETE FROM `s_core_config_elements` WHERE `form_id` = ? AND `name` = ?';
			Shopware()->Db()->query($delete, array($formID, $name));
		} catch (Exception $e) {
			// Nix
		}
	}
	
	private function updateSnippets()
	{
		$sql = "DELETE FROM s_core_snippets WHERE namespace LIKE ?";
		Shopware()->Db()->query($sql, array('%backend/plugins/connector_yatego/view/config%'));
		
		$sql = "DELETE FROM s_core_snippets WHERE namespace LIKE ?";
		Shopware()->Db()->query($sql, array('%CbaxConnectorYatego%'));
	}
	
	private function cleanUpFiles()
	{
		// Alle alten Log Einträge des Account löschen
		$sql = "DELETE FROM s_plugin_externalorder_log WHERE LOWER(account) = ?";
		Shopware()->Db()->query($sql, array(strtolower($this->constants['account_name'])));
		
		// alte Base Connector Dateien löschen
		if (file_exists($this->Path().'/Util/Connectors/BaseApiConnector.class.php')) {
            unlink ($this->Path().'/Util/Connectors/BaseApiConnector.class.php');
        }
		
		if (file_exists($this->Path().'/Util/Connectors/YategoApiConnector.class.php')) {
            unlink ($this->Path().'/Util/Connectors/YategoApiConnector.class.php');
			rmdir($this->Path().'/Util/Connectors');
			rmdir($this->Path().'/Util');
        }
		
		if (file_exists($this->Path().'/Views/backend/connector_yatego/store/orderstate.js')) {
            unlink ($this->Path().'/Views/backend/connector_yatego/store/orderstate.js');
			unlink ($this->Path().'/Views/backend/connector_yatego/store/paymentstate.js');
        }
		
		if (file_exists($this->Path().'/Views/backend/connector_yatego/model/orderstate.js')) {
            unlink ($this->Path().'/Views/backend/connector_yatego/model/orderstate.js');
			unlink ($this->Path().'/Views/backend/connector_yatego/model/paymentstate.js');
        }
	}
	
	public function onInitResourceYategoOrdersBase(Enlight_Event_EventArgs $args)
	{
		$this->Application()->Loader()->registerNamespace('Shopware_Components', dirname(__FILE__) . '/Components/');
		
		$base = new Shopware_Components_YategoOrdersBase($this->constants, $this->settings);
		
        return $base;
	}
	
	public function onInitResourceYategoOrdersClient(Enlight_Event_EventArgs $args)
	{
		$this->Application()->Loader()->registerNamespace('Shopware_Components', dirname(__FILE__) . '/Components/');
		
		$client = new Shopware_Components_YategoOrdersClient($this->constants, $this->settings);
		
        return $client;
	}
	
	public function onInitResourceYategoOrdersConnector(Enlight_Event_EventArgs $args)
	{
		$this->Application()->Loader()->registerNamespace('Shopware_Components', dirname(__FILE__) . '/Components/');
		
		$connector = new Shopware_Components_YategoOrdersConnector($this->constants, $this->settings);
		
        return $connector;
	}
	
	public function onRunImportOrder(Shopware_Components_Cron_CronJob $job)
	{
		$orders = self::runAutoImport();
		
		return $orders.' Bestellungen importiert';
	}
	
	public function runAutoImport()
	{
		$counter = Shopware()->YategoOrdersConnector()->importOrderAutomatic();
		
		return intval($counter);
	}
	
	public function sendShippingStatus($orderID = -1)
	{
		$result['success'] 	= false;
		$result['error_msg']   = 'Bei Yatego ist ein Senden des Versandstatus NICHT möglich!';
		return $result;
	}
	
	public function importSingleOrder($externalOrderNumber)
	{
		$result = Shopware()->YategoOrdersConnector()->importOrderManual($externalOrderNumber);

		return $result;
	}
	
	public function loadConstants()
	{
		$file = realpath(__DIR__ . '/Base/Constants.php');

		$constants = include $file;

		if (!is_array($constants)) {
			return array();
		}
		
		$constants = array_change_key_case($constants, CASE_LOWER);
		
		return $constants;
	}
}
