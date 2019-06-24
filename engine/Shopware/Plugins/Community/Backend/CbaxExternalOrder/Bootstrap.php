<?php

use Shopware\Bundle\AttributeBundle\Service\CrudService;
use Shopware\Bundle\AttributeBundle\Service\TypeMapping;

require_once __DIR__ . '/Components/CSRFWhitelistAware.php';

class Shopware_Plugins_Backend_CbaxExternalOrder_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
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
		return 'Externe Bestellungen';
	}

	public function getVersion()
	{
		return '2.7.2';
	}

	public function enable()
	{
		return array(
			'success' => true,
			'invalidateCache' => array('backend')
		);
	}

	/**
	 * @return array|bool
	 * @throws Enlight_Exception
	 * @throws Exception
	 * @throws Zend_Db_Adapter_Exception
	 */
	public function install()
	{
		if (Shopware()->Acl()->hasResourceInDatabase('externalorder')) {
			$this->deleteResource('externalorder');
		}
		
		Shopware()->Acl()->createResource('externalorder', array('read', 'update', 'import', 'generate', 'delete'), 'Externe Bestellungen', $this->getId());
		
		$this->createForm();
		$this->createEvents();
		$this->createCronJobs();
		$this->createMyTranslations();
		$this->createMenu();
		$this->createDatabaseTables();
		$this->updateDatabaseTables();
		$this->createMail();
		$this->updateSnippets();
		$this->cleanUpFiles();

		$this->createAttributes();
		return true;
	}

	/**
	 * @return array|bool
	 * @throws Zend_Db_Adapter_Exception
	 */
	public function uninstall()
    {
		$this->deleteResource('externalorder');

		// Mail löschen
		$sql = 'DELETE FROM s_core_config_mails WHERE s_core_config_mails.name = "PluginExternalOrderLog"';
		Shopware()->Db()->query($sql);
		
		$this->removeAttributes();
        return true;
    }

	/**
	 * @param string $oldVersion
	 * @return array|bool
	 * @throws Exception
	 */
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
			case '2.2.8':
			case '2.2.9':
			case '2.3.0':
			case '2.3.1':
			case '2.3.2':
			case '2.3.3':
			case '2.3.4':
			case '2.3.5':
			case '2.3.6':
			case '2.3.7':
			case '2.3.8':
			case '2.3.9':
			case '2.4.0':
			case '2.4.1':
			case '2.4.2':
			case '2.4.3':
			case '2.4.4':
			case '2.4.5':
			case '2.4.6':
			case '2.4.7':
			case '2.4.8':
			case '2.4.9':
			case '2.5.0':
			case '2.5.1':
			case '2.5.2':
			case '2.5.3':
			case '2.5.4':
			case '2.5.5':
			case '2.5.6':
			case '2.5.7':
			case '2.5.8':
			case '2.5.9':
			case '2.6.0':
			case '2.6.1':
			case '2.6.2':
			case '2.6.3':
			case '2.6.4':
			case '2.6.5':
			case '2.6.6':
			case '2.6.7':
			case '2.6.8':
			case '2.6.9':
			case '2.7.0':
			case '2.7.1':
				break;
			default:
				//Die installierte Version entspricht keiner hier aufgeführten Version
				//Aus diesem Grund wird dem Plugin-Manager mitgeteilt,
				//dass das Update fehlgeschlagen ist.
				//return false;
		}

		$this->createForm();
		$this->createEvents();
		$this->updateDatabaseTables();
		$this->updateSnippets();
		$this->cleanUpFiles();

		$this->createAttributes();

		// Falls alte Einstellung vorhanden, Attribute tauschen
		$order_attr = $this->Config()->get('order_attr', '');
		if (!empty($order_attr)) {
			$this->takeOverAttributes($order_attr);
		}
		$this->removeFormElement('order_attr');
		
		return array(
            'success' => true,
            'invalidateCache' => array('backend')
        );
	}

	protected function createForm()
    {
        $form = $this->Form();
		/** @var Shopware\Models\Config\Form $parent */
		$parent = $this->Forms()->findOneBy(array('name' => 'Interface'));
        $form->setParent($parent);
		$form->setElement('number', 'create_orderlimit', array(
			'label' => 'Import Limit Shopware Bestellungen',
			'required' => true,
			'value' => 50,
			'description' => 'Limit für das Erstellen der Shopware Bestellungen.',
			'position' => 0
		));
		$form->setElement('select', 'status_shipping', array(
            'label' => 'Bestellstatus versendet',
            'value' => array(6, 7),
            'store' => 'base.OrderStatus',
            'displayField' => 'description',
            'valueField' => 'id',
			'multiSelect' => true,
			'editable' => false,
			'description' => 'Ab wann gilt eine Bestellung als versendet um den Versandstatus an den jeweiligen Marktplatz zu melden.',
			'position' => 1
        ));
		$form->setElement('text', 'email', array(
			'label' => 'E-Mail Adresse',
			'value' => '',
			'description' => 'Die E-Mail Adresse an die die Fehler versendet werden',
			'position' => 2
		));
		$form->setElement('checkbox', 'debug', array(
			'label' => 'Debug',
			'value' => false,
			'description' => 'Debug Modus. Nur zur Ausgabe von detaillierten E-Mail Meldungen',
			'position' => 3
		));
		$form->setElement('button', 'order_modul_settings', array(
			'label' => 'Einstellungen Shopware Bestellübersicht',
			'position' => 4
		));
		$form->setElement('checkbox', 'hide_transactionId', array(
			'label' => 'Spalte Transaktion ausblenden',
			'value' => false,
			'description' => 'Blendet diese Spalte in der Shopware Bestellübersicht standardmäßig ein oder aus.',
			'position' => 5
		));
		$form->setElement('checkbox', 'hide_paymentId', array(
			'label' => 'Spalte Zahlungsart ausblenden',
			'value' => false,
			'description' => 'Blendet diese Spalte in der Shopware Bestellübersicht standardmäßig ein oder aus.',
			'position' => 6
		));
		$form->setElement('checkbox', 'hide_dispatchId', array(
			'label' => 'Spalte Versand ausblenden',
			'value' => false,
			'description' => 'Blendet diese Spalte in der Shopware Bestellübersicht standardmäßig ein oder aus.',
			'position' => 7
		));
		$form->setElement('checkbox', 'hide_shopId', array(
			'label' => 'Spalte Shop ausblenden',
			'value' => false,
			'description' => 'Blendet diese Spalte in der Shopware Bestellübersicht standardmäßig ein oder aus.',
			'position' => 8
		));
		$form->setElement('checkbox', 'hide_partnerId', array(
			'label' => 'Spalte Marktplatz ausblenden',
			'value' => false,
			'description' => 'Blendet diese Spalte in der Shopware Bestellübersicht standardmäßig ein oder aus.',
			'position' => 9
		));
		$form->setElement('checkbox', 'hide_customerEmail', array(
			'label' => 'Spalte E-Mail ausblenden',
			'value' => true,
			'description' => 'Blendet diese Spalte in der Shopware Bestellübersicht standardmäßig ein oder aus.',
			'position' => 10
		));
		$form->setElement('button', 'optional_settings', array(
			'label' => 'Optionale Einstellungen',
			'position' => 11
		));
		$form->setElement('text', 'cron_key', array(
			'label' => 'Gültiger Schlüssel',
			'value' => '',
			'description' => 'Optional - Sie müssen dieses Feld nicht ausfüllen. Hinweise finden Sie im Handbuch auf unserer Website.',
			'position' => 12
		));
		$form->setElement('text', 'proxy', array(
			'label' => 'Proxy-Server',
			'value' => '',
			'description' => 'Optional - Sie müssen dieses Feld nicht ausfüllen. Hinweise finden Sie im Handbuch auf unserer Website.',
			'position' => 13
		));
    }

	/**
	 * @throws Exception
	 */
	protected function createEvents()
    {
		$this->registerController('Backend', 'ExternalOrder');
		
		$this->registerController('Backend', 'ExternalOrderApi');
		
		$this->registerController('Backend', 'ExternalOrderBase');
		
		$this->registerController('Backend', 'ExternalOrderLogfile');
		
		$this->subscribeEvent(
	 		'Enlight_Bootstrap_InitResource_ExternalOrderBase',
	 		'onInitResourceExternalOrderBase'
	 	);
		
		$this->subscribeEvent(
	 		'Enlight_Bootstrap_InitResource_ExternalOrderDb',
	 		'onInitResourceExternalOrderDb'
	 	);

		$this->subscribeEvent(
			'Shopware_Controllers_Backend_Config::saveTableValuesAction::before',
			'beforeSaveTableValuesAction'
		);

		$this->subscribeEvent(
			'Enlight_Controller_Action_PostDispatch_Backend_Order',
			'loadBackendModuleOrder'
		);
    }
	
	private function createCronJobs()
	{
		$this->subscribeEvent(
			'Shopware_CronJob_CbaxExternalOrderSetStatus',
			'onRunSetStatus'
		);
		
		$this->createCronJob(
			'Status bei versandten Bestellungen in Tabelle setzen',
			'CbaxExternalOrderSetStatus',
			3600,
			true
		);
		
		$this->subscribeEvent(
			'Shopware_CronJob_CbaxExternalOrderGenerate',
			'onRunCreateShopwareOrder'
		);
		
		$this->createCronJob(
			'Shopware Bestellungen aus externen Accounts erstellen',
			'CbaxExternalOrderGenerate',
			600,
			true
		);
	}
	
	protected function createMyTranslations()
    {
        $form = $this->Form();
        $translations = array(
            'en_GB' => array(
				'create_orderlimit' => array('label' => 'Import Limit Shopware orders', 'description' => 'Limit for the creation of Shopware orders'),
				'status_shipping' => array('label' => 'Order shipped', 'description' => 'When will an order is deemed to be shipped to the shipping status of the respective marketplace announce'),
				'email' => array('label' => 'E-Mail Adress', 'description' => 'The e-mail address will be shipped to the mistakes'),
				'order_modul_settings' => array('label' => 'Settings Shopware Order overview'),
				'hide_transactionId' => array('label' => 'Hide Transaction column', 'description' => 'Shows or hides this column in the Shopware order overview by default.'),
				'hide_paymentId' => array('label' => 'Hide Payment column', 'description' => 'Shows or hides this column in the Shopware order overview by default.'),
				'hide_dispatchId' => array('label' => 'Hide Dispatch column', 'description' => 'Shows or hides this column in the Shopware order overview by default.'),
				'hide_shopId' => array('label' => 'Hide Shop column', 'description' => 'Shows or hides this column in the Shopware order overview by default.'),
				'hide_partnerId' => array('label' => 'Hide Partner column', 'description' => 'Shows or hides this column in the Shopware order overview by default.'),
				'hide_customerEmail' => array('label' => 'Hide Customer column', 'description' => 'Shows or hides this column in the Shopware order overview by default.'),
				'optional_settings' => array('label' => 'Optional Settings'),
				'cron_key' => array('label' => 'Valid key', 'description' => 'Optional - you do not fill in this field. Notes, refer to our website'),
				'proxy' => array('label' => 'Proxy server', 'description' => 'Optional - you do not fill in this field. Notes, refer to our website')
            )
        );
        $shopRepository = Shopware()->Models()->getRepository('\Shopware\Models\Shop\Locale');
        foreach($translations as $locale => $snippets) {
			/** @var Shopware\Models\Shop\Locale $localeModel */
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
	
	protected function createMenu()
    {
		$parent = $this->Menu()->findOneBy(array('label' => 'logfile'));
        $this->createMenuItem(array(
            'label' => 'Externe Bestellungen Log',
            'controller' => 'ExternalOrderLogfile',
            'action' => 'Index',
            'class' => 'sprite-cards-stack',
            'active' => 1,
            'parent' => $parent
        ));
		
		$parent = $this->Menu()->findOneBy(array('label' => 'Kunden'));
        $this->createMenuItem(array(
            'label' => 'Externe Bestellungen',
            'controller' => 'ExternalOrder',
            'action' => 'Index',
            'class' => 'sprite-sticky-notes-pin',
            'active' => 1,
			'position' => 2,
            'parent' => $parent
        ));
    }

	/**
	 * @throws Zend_Db_Adapter_Exception
	 */
	private function createDatabaseTables()
	{
		$sql = "CREATE TABLE IF NOT EXISTS `s_plugin_externalorder_account` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(100) NOT NULL,
					`description` varchar(100) NOT NULL,
					`plugin` varchar(100) NOT NULL,
					`controller` varchar(100) NOT NULL,
					PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";
		Shopware()->Db()->query($sql);
		
		$sql = "CREATE TABLE IF NOT EXISTS `s_plugin_externalorder_log` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`account` varchar(255) NOT NULL,
					`date` datetime DEFAULT NULL,
					`type` varchar(255) DEFAULT NULL,
					`msg` varchar(255) DEFAULT NULL,
					`action` varchar(255) DEFAULT NULL,
					`debugdata` text,
					PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";
		Shopware()->Db()->query($sql);
		
		$sql = "CREATE TABLE IF NOT EXISTS `s_plugin_externalorder_order` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`account` varchar(255) DEFAULT NULL,
					`external_order_number` varchar(30) DEFAULT NULL,
					`created` datetime DEFAULT NULL,
					`invoice_amount` double DEFAULT NULL,
					`invoice_amount_net` double DEFAULT NULL,
					`invoice_shipping` double DEFAULT NULL,
					`invoice_shipping_net` double DEFAULT NULL,
					`invoice_shipping_tax_rate` double DEFAULT NULL,
					`status` int(11) DEFAULT NULL,
					`cleared` int(11) DEFAULT NULL,
					`paymentID` int(11) DEFAULT NULL,
					`transactionID` varchar(255) DEFAULT NULL,
					`comment` text,
					`customercomment` text,
					`internalcomment` text,
					`payment_instruction` text,
					`language` varchar(10) DEFAULT NULL,
					`dispatchID` int(11) DEFAULT NULL,
					`imported` datetime DEFAULT NULL,
					`subshopID` int(11) DEFAULT NULL,
					`taxID` int(1) DEFAULT NULL,
					`currency_currency` varchar(5) DEFAULT NULL,
					`currency_factor` double DEFAULT NULL,
					`dropshipping` int(1) DEFAULT NULL,
					`ordertime` datetime DEFAULT '0000-00-00 00:00:00',
					`generate_error` int(1) DEFAULT NULL,
					`orderID` int(11) DEFAULT '0',
					`ordernumber` varchar(30) DEFAULT NULL,
					`carrier` varchar(255) DEFAULT NULL,
					`trackingcode` varchar(255) DEFAULT NULL,
					`shipped_to_account` int(1) DEFAULT NULL,
					`attribute1` varchar(255) DEFAULT NULL,
					`attribute2` varchar(255) DEFAULT NULL,
					`attribute3` varchar(255) DEFAULT NULL,
					PRIMARY KEY (`id`),
					INDEX(`account`),
					INDEX(`external_order_number`),
					INDEX(`subshopID`),
					INDEX(`orderID`),
					INDEX(`ordernumber`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";
		Shopware()->Db()->query($sql);
		
		$sql = "CREATE TABLE IF NOT EXISTS `s_plugin_externalorder_order_billingaddress` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`importOrderID` int(11) DEFAULT NULL,
					`customergroup` varchar(30) DEFAULT NULL,
					`salutation` varchar(30) DEFAULT NULL,
					`company` varchar(255) DEFAULT NULL,
					`firstname` varchar(100) DEFAULT NULL,
					`lastname` varchar(100) DEFAULT NULL,
					`street` varchar(255) DEFAULT NULL,
					`streetnumber` varchar(30) DEFAULT NULL,
					`zipcode` varchar(30) DEFAULT NULL,
					`city` varchar(255) DEFAULT NULL,
					`countryID` int(11) DEFAULT NULL,
					`email` varchar(255) DEFAULT NULL,
					`phone` varchar(50) DEFAULT NULL,
					`fax` varchar(50) DEFAULT NULL,
					`birthday` date DEFAULT NULL,
					`additional_address_line1` varchar(255) DEFAULT NULL,
					`additional_address_line2` varchar(255) DEFAULT NULL,
					`text1` varchar(255) DEFAULT NULL,
					`text2` varchar(255) DEFAULT NULL,
					`text3` varchar(255) DEFAULT NULL,
					PRIMARY KEY (`id`),
					INDEX(`importOrderID`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";
		Shopware()->Db()->query($sql);
		
		$sql = "CREATE TABLE IF NOT EXISTS `s_plugin_externalorder_order_details` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`importOrderID` int(11) DEFAULT NULL,
					`external_order_number` varchar(30) DEFAULT NULL,
					`external_article_number` varchar(50) DEFAULT NULL,
					`articleordernumber` varchar(32) DEFAULT NULL,
					`name` varchar(255) DEFAULT NULL,
					`price` double DEFAULT NULL,
					`quantity` int(11) DEFAULT NULL,
					`modus` int(1) DEFAULT NULL,
					`taxID` int(2) DEFAULT NULL,
					`tax_rate` double DEFAULT NULL,
					`attribute1` varchar(255) DEFAULT NULL,
					`attribute2` varchar(255) DEFAULT NULL,
					`attribute3` varchar(255) DEFAULT NULL,
					PRIMARY KEY (`id`),
					INDEX(`importOrderID`),
					INDEX(`articleordernumber`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";
		Shopware()->Db()->query($sql);
		
		$sql = "CREATE TABLE IF NOT EXISTS `s_plugin_externalorder_order_shippingaddress` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`importOrderID` int(11) DEFAULT NULL,
					`salutation` varchar(30) DEFAULT NULL,
					`company` varchar(255) DEFAULT NULL,
					`firstname` varchar(100) DEFAULT NULL,
					`lastname` varchar(100) DEFAULT NULL,
					`street` varchar(255) DEFAULT NULL,
					`streetnumber` varchar(30) DEFAULT NULL,
					`zipcode` varchar(30) DEFAULT NULL,
					`city` varchar(255) DEFAULT NULL,
					`countryID` int(11) DEFAULT NULL,
					`phone` varchar(50) DEFAULT NULL,
					`fax` varchar(50) DEFAULT NULL,
					`additional_address_line1` varchar(255) DEFAULT NULL,
					`additional_address_line2` varchar(255) DEFAULT NULL,
					`text1` varchar(255) DEFAULT NULL,
					`text2` varchar(255) DEFAULT NULL,
					`text3` varchar(255) DEFAULT NULL,
					PRIMARY KEY (`id`),
					INDEX(`importOrderID`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";
		Shopware()->Db()->query($sql);
	}

	/**
	 * @throws Zend_Db_Adapter_Exception
	 */
	private function updateDatabaseTables()
	{
		$db = Shopware()->Db();
		
		if (!$this->columnExist('s_plugin_externalorder_order', 'invoice_shipping_tax_rate')) {
			$db->exec("ALTER TABLE `s_plugin_externalorder_order` ADD `invoice_shipping_tax_rate` double DEFAULT NULL AFTER `invoice_shipping_net`;");
		}
		if (!$this->columnExist('s_plugin_externalorder_order', 'carrier')) {
			$db->exec("ALTER TABLE `s_plugin_externalorder_order` ADD `carrier` varchar(255) DEFAULT NULL AFTER `ordernumber`;");
		}
		if (!$this->columnExist('s_plugin_externalorder_order', 'payment_instruction')) {
			$db->exec("ALTER TABLE `s_plugin_externalorder_order` ADD `payment_instruction` text AFTER `internalcomment`;");
		}
		if (!$this->columnExist('s_plugin_externalorder_order', 'generate_error')) {
			$db->exec("ALTER TABLE `s_plugin_externalorder_order` ADD `generate_error` int(1) NULL AFTER `ordertime`;");
		}
		if ($this->columnExist('s_plugin_externalorder_order', 'automatic_import')) {
			$db->exec("ALTER TABLE `s_plugin_externalorder_order` DROP `automatic_import`;");
		}
		if (!$this->columnExist('s_plugin_externalorder_order', 'language')) {
			$db->exec("ALTER TABLE `s_plugin_externalorder_order` ADD `language` varchar(10) NULL AFTER `internalcomment`;");
		}
		if (!$this->columnExist('s_plugin_externalorder_order', 'dropshipping')) {
			$db->exec("ALTER TABLE `s_plugin_externalorder_order` ADD `dropshipping` int(1) NULL AFTER `currency_factor`;");
		}
		if (!$this->columnExist('s_plugin_externalorder_order_details', 'external_article_number')) {
			$db->exec("ALTER TABLE `s_plugin_externalorder_order_details` ADD `external_article_number` varchar(50) DEFAULT NULL AFTER `external_order_number`;");
		}
		$columnSchema = $this->getColumnSchema('s_plugin_externalorder_order_billingaddress', 'streetnumber');
		if ($columnSchema['CHARACTER_MAXIMUM_LENGTH'] !== '30') {
			Shopware()->Db()->exec("ALTER TABLE `s_plugin_externalorder_order_billingaddress` CHANGE `streetnumber` `streetnumber` VARCHAR(30) NULL DEFAULT NULL;");
		}
		$columnSchema = $this->getColumnSchema('s_plugin_externalorder_order_shippingaddress', 'streetnumber');
		if ($columnSchema['CHARACTER_MAXIMUM_LENGTH'] !== '30') {
			Shopware()->Db()->exec("ALTER TABLE `s_plugin_externalorder_order_shippingaddress` CHANGE `streetnumber` `streetnumber` VARCHAR(30) NULL DEFAULT NULL;");
		}
	}

	/**
	 * @throws Zend_Db_Adapter_Exception
	 */
	private function createMail()
    {
		$sql = 'INSERT IGNORE INTO s_core_config_mails
				(id, stateId, name, frommail, fromname, subject, content, contentHTML, ishtml, attachment, mailtype, context)
				VALUES
				(NULL, NULL, "PluginExternalOrderLog", "{config name=mail}", "{config name=shopName}", "Fehler bei einer externen Bestellung von {$account|ucwords}", "Bei einer Bestellung von {$account|ucwords} ist ein Fehler aufgetreten:\n\nAccount: {$account|ucwords}\nType: {$type}\nMessage: {$msg}\nAction: {$action}\nDebug: {$debugData}", "", 0, "", 1, "")';
		Shopware()->Db()->query($sql);
    }
	
	private function createAttributes()
	{
		try {
			/** @var CrudService $crudService */
			$crudService = Shopware()->Container()->get('shopware_attribute.crud_service');
			
			$crudService->update('s_order_attributes', 'cbax_external_order_carrier', TypeMapping::TYPE_STRING);
			$crudService->update('s_order_attributes', 'cbax_external_order_payment_instruction', TypeMapping::TYPE_TEXT);
			$crudService->update('s_order_attributes', 'cbax_external_order_ordernumber', TypeMapping::TYPE_STRING);

			Shopware()->Models()->generateAttributeModels(array(
				's_order_attributes'
			));
		} catch (Exception $e) {
			// Nix
		}
	}
	
	public function removeAttributes()
	{
		try {
			/** @var CrudService $crudService */
			$crudService = Shopware()->Container()->get('shopware_attribute.crud_service');
			
			$crudService->delete('s_order_attributes', 'cbax_external_order_carrier');
			//$crudService->delete('s_order_attributes', 'cbax_external_order_payment_instruction');
			//$crudService->delete('s_order_attributes', 'cbax_external_order_ordernumber');
			
			Shopware()->Models()->generateAttributeModels(array(
				's_order_attributes'
			));
		} catch (Exception $e) {
			// Nix
		}
	}

	/**
	 * @throws Zend_Db_Adapter_Exception
	 */
	private function takeOverAttributes($order_attr)
	{
		$db = Shopware()->Db();
		// Attribut übernehmen
		$sql = "UPDATE `s_order_attributes` SET `cbax_external_order_ordernumber` = " . $db->quoteIdentifier("attribute" . $order_attr);
		$db->query($sql);
	}

	public function removeFormElement($name)
	{
		try {
			// Form-ID ermitteln
			$sql = "SELECT `id` FROM `s_core_config_forms` WHERE `name` = 'CbaxExternalOrder'";
			$formId = Shopware()->Db()->fetchOne($sql);

			// Element-ID ermitteln
			$sql = "SELECT `id` FROM `s_core_config_elements` WHERE `name` = ?";
			$elementId = Shopware()->Db()->fetchOne($sql, array($name));

			// Element löschen
			$delete = 'DELETE FROM `s_core_config_elements` WHERE `form_id` = ? AND `name` = ?';
			Shopware()->Db()->query($delete, array($formId, $name));

			// Wert löschen
			$delete = 'DELETE FROM `s_core_config_values` WHERE `element_id` = ?';
			Shopware()->Db()->query($delete, array($elementId));
		} catch (Exception $e) {
			// Nix
		}
	}
	
	private function updateSnippets()
	{
		$sql = "DELETE FROM s_core_snippets WHERE namespace LIKE ?";
		Shopware()->Db()->query($sql, array('backend/order/external_order/main'));
		
		$sql = "DELETE FROM s_core_snippets WHERE namespace LIKE ?";
		Shopware()->Db()->query($sql, array('backend/plugins/external_order/view/filterpanel'));
		
		$sql = "DELETE FROM s_core_snippets WHERE namespace LIKE ?";
		Shopware()->Db()->query($sql, array('backend/plugins/external_order/view/list'));
		
		$sql = "DELETE FROM s_core_snippets WHERE namespace LIKE ?";
		Shopware()->Db()->query($sql, array('backend/plugins/external_order/view/statistic'));
		
		$sql = "DELETE FROM s_core_snippets WHERE namespace LIKE ?";
		Shopware()->Db()->query($sql, array('backend/plugins/external_order/view/import'));
		
		$sql = "DELETE FROM s_core_snippets WHERE namespace LIKE ?";
		Shopware()->Db()->query($sql, array('backend/plugins/external_order/view/detail'));
		
		$sql = "DELETE FROM s_core_snippets WHERE namespace LIKE ?";
		Shopware()->Db()->query($sql, array('backend/plugins/lexexternal_ordericon/view/detail/detail'));
		
		$sql = "DELETE FROM s_core_snippets WHERE namespace LIKE ?";
		Shopware()->Db()->query($sql, array('backend/plugins/external_order_logfile/view/edit'));
		
		$sql = "DELETE FROM s_core_snippets WHERE namespace LIKE ?";
		Shopware()->Db()->query($sql, array('backend/plugins/external_order_logfile/view/list'));
		
		$sql = "DELETE FROM s_core_snippets WHERE namespace LIKE ?";
		Shopware()->Db()->query($sql, array('%CbaxExternalOrder%'));
	}
	
	private function cleanUpFiles()
	{
		if (file_exists($this->Path().'/Views/backend/external_order/store/status.js')) {
            unlink ($this->Path().'/Views/backend/external_order/store/status.js');
        }
		
		if (file_exists($this->Path().'/Views/backend/external_order/model/status.js')) {
            unlink ($this->Path().'/Views/backend/external_order/model/status.js');
        }
	}
	
	public function onInitResourceExternalOrderBase(Enlight_Event_EventArgs $args)
	{
		$this->Application()->Loader()->registerNamespace('Shopware_Components', dirname(__FILE__) . '/Components/');

		$externalOrderBase = new Shopware_Components_ExternalOrderBase($this->Config());

        return $externalOrderBase;
	}
	
	public function onInitResourceExternalOrderDb(Enlight_Event_EventArgs $args)
	{		
		$this->Application()->Loader()->registerNamespace('Shopware_Components', dirname(__FILE__) . '/Components/');

		$externalOrderDb = new Shopware_Components_ExternalOrderDb($this->Config());
		
        return $externalOrderDb;
	}

	public function beforeSaveTableValuesAction(Enlight_Event_EventArgs $args)
	{
		$controller = $args->getSubject();
		$request	= $controller->Request();

		$job = $request->getPost();

		switch ($job['action']) {
			case 'Shopware_CronJob_CbaxConnectorAmazonImportOrder':
				$job = $this->modifyCronJob($job, 1800);
				break;
			case 'Shopware_CronJob_CbaxConnectorAmazonSendStatus':
				if ($job['interval'] < 3600) {
					$job = $this->modifyCronJob($job, 3600);
				}
				break;
			case 'Shopware_CronJob_CbaxConnectorAmazonExportInstock':
				if ($job['interval'] < 1800) {
					$job = $this->modifyCronJob($job, 1800);
				}
				break;
		}

		$request->setPost($job);
	}

	public function loadBackendModuleOrder(Enlight_Event_EventArgs $args)
	{
		$config = $this->Config();

		$view = $args->getSubject()->View();
		$view->addTemplateDir($this->Path() . 'Views/');

		if ($args->getRequest()->getActionName() === 'load') {
			$externalOrder['hide_transactionId']	= $config->hide_transactionId;
			$externalOrder['hide_paymentId']		= $config->hide_paymentId;
			$externalOrder['hide_dispatchId']		= $config->hide_dispatchId;
			$externalOrder['hide_shopId']			= $config->hide_shopId;
			$externalOrder['hide_partnerId']		= $config->hide_partnerId;
			$externalOrder['hide_customerEmail']	= $config->hide_customerEmail;

			$view->externalOrder = $externalOrder;
			
			$view->extendsTemplate('backend/order/external_order/controller/detail.js');
			$view->extendsTemplate('backend/order/external_order/view/detail/overview.js');
			$view->extendsTemplate('backend/order/external_order/view/list/list.js');
		}
	}

	private function modifyCronJob($job, $intervall)
	{
		$job['interval'] = $intervall;

		$start = new DateTime($job['start']);
		$start->add(new DateInterval('PT' . strval($intervall) . 'S'));
		$job['next'] = $start->format('Y-m-d\TH:i:s');

		return $job;
	}

	/**
	 * Wenn Status der Bestellung auf teilweise oder komplett Versendet, dann Flag in externer Tabelle setzen
	 *
	 * @param Shopware_Components_Cron_CronJob $job
	 * @return string
	 * @throws Enlight_Event_Exception
	 * @throws Zend_Db_Adapter_Exception
	 */
	public function onRunSetStatus(Shopware_Components_Cron_CronJob $job)
	{
		$orders = self::runSetStatus();
		
		return $orders.' Bestellungen aktualisiert';
	}

	// Shopware Bestellung generieren
	public function onRunCreateShopwareOrder(Shopware_Components_Cron_CronJob $job)
	{
		$orders = self::runCreateShopwareOrder();
		
		return $orders.' Shopware Bestellungen generiert';
	}

	/**
	 * @return int
	 * @throws Enlight_Event_Exception
	 * @throws Zend_Db_Adapter_Exception
	 */
	public function runSetStatus()
	{
		$config = $this->Config();
		
		$status_shipping = implode(',', $config->status_shipping->toArray());
		
		$sql = "
		SELECT
			o.id,
			o.ordernumber,
			o.trackingcode,
		  	peo.account,
			oa.cbax_external_order_carrier AS carrier
		FROM
			s_order AS o,
			s_plugin_externalorder_order AS peo,
			s_order_attributes AS oa
		
	  	WHERE o.id = peo.orderID
	  	AND o.id = oa.orderID
	  	AND peo.shipped_to_account = 0
	  	AND o.status IN (".$status_shipping.")
	  	LIMIT 50";
		$orders = Shopware()->Db()->fetchAll($sql);

		$orders = Shopware()->Events()->filter(
			'Cbax_ExternalOrder_RunSetStatus_BeforeSet',
			$orders,
			array('subject' => $this)
		);

		if (count($orders) > 0) {
			foreach ($orders as $order) {
				// Falls mehrere Tracking Codes mit Komma getrennt wurden, nur den ersten nehmen
				$trackingCodes = explode(',', trim($order['trackingcode']));
				$sql = "UPDATE s_plugin_externalorder_order SET trackingcode = ?, carrier = ?, shipped_to_account = 1 WHERE orderID = ?";
				Shopware()->Db()->query($sql, array($trackingCodes[0], $order['carrier'], $order["id"]));
			}

			return count($orders);
		} else {
			return 0;
		}
	}
	
	public function runCreateShopwareOrder()
	{
		$orderIDs = Shopware()->ExternalOrderDb()->getOrdersToGenerate();
		if (count($orderIDs) > 0) {
			foreach ($orderIDs as $orderID) {
				$order = Shopware()->ExternalOrderDb()->getExternalOrder($orderID['id']);

				self::generateShopwareOrder($order);
			}

			return count($orderIDs);
		} else {
			return 0;
		}
	}
	
	public function generateShopwareOrder($order)
	{
		$check = Shopware()->ExternalOrderDb()->checkOrderForGenerate($order);
		if ($check['success'] !== true) {
			return $check;
		}
		
		$result = Shopware()->ExternalOrderDb()->saveShopwareOrder($order);

		return $result;
	}

	/**
	 * @param $resourceName
	 * @throws Zend_Db_Adapter_Exception
	 */
	private function deleteResource($resourceName)
	{
		$sql = "SELECT id FROM s_core_acl_resources WHERE name = ?";
		$resourceID = Shopware()->Db()->fetchOne($sql, array($resourceName));

		$delete = 'DELETE FROM s_core_acl_resources WHERE id = ?';
		Shopware()->Db()->query($delete, array($resourceID));

		$delete = 'DELETE FROM s_core_acl_privileges WHERE resourceID = ?';
		Shopware()->Db()->query($delete, array($resourceID));

		$delete = 'DELETE FROM  s_core_acl_roles WHERE resourceID = ?';
		Shopware()->Db()->query($delete, array($resourceID));
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

	/**
	 * @param $table
	 * @param $column
	 * @return mixed
	 */
	private function getColumnSchema($table, $column)
	{
		$sql = "
		SELECT
			*
		FROM
			INFORMATION_SCHEMA.COLUMNS
		WHERE
			table_name = ?
		AND
			column_name = ?;
  		";
		$columnSchema = Shopware()->Db()->fetchRow($sql, array($table, $column));

		return $columnSchema;
	}
}