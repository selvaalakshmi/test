<?php

class Shopware_Controllers_Backend_ExternalOrderBase extends Shopware_Controllers_Backend_ExtJs
{
	private $plugin;

	/** @var Shopware_Components_ExternalOrderBase externalOrderBase */
	private $externalOrderBase;

	public function init()
	{
		$this->externalOrderBase = Shopware()->ExternalOrderBase();
		$this->plugin = Shopware()->Plugins()->Backend()->CbaxExternalOrder();
		
		parent::init();
	}
	
	public function getAccountsAction()
	{
		$sql = "
		SELECT
			id,
			name,
			description
		FROM
			s_plugin_externalorder_account
		ORDER BY description ASC";
		$data = Shopware()->Db()->fetchAll($sql);

		$this->View()->assign(array('success' => true, 'data' => $data));
	}
	
	public function getPaymentsAction()
	{
		$sql = "
		SELECT
			id,
			description AS name
		FROM
			s_core_paymentmeans";
		$data = Shopware()->Db()->fetchAll($sql);

		$this->View()->assign(array('success' => true, 'data' => $data));
	}
	
	public function getShopsAction()
	{
		$sql = "
		SELECT 
			id, 
			name
		FROM
			s_core_shops";
		$data = Shopware()->Db()->fetchAll($sql);

		$this->View()->assign(array('success' => true, 'data' => $data));
	}
	
	public function getTaxesAction()
	{
		$sql = "
		SELECT
			id,
			description AS name
		FROM
			s_core_tax";
		$data = Shopware()->Db()->fetchAll($sql);

		$this->View()->assign(array('success' => true, 'data' => $data));
	}
	
	public function getDispatchesAction()
	{
		$sql = "
		SELECT
			id,
			name
		FROM
			s_premium_dispatch";
		$data = Shopware()->Db()->fetchAll($sql);
		
		$this->View()->assign(array('success' => true, 'data' => $data));
	}
	
	public function getCustomerGroupsAction()
	{
		$sql = "
		SELECT
			id,
			groupkey,
			description AS name
		FROM
			s_core_customergroups";
		$data = Shopware()->Db()->fetchAll($sql);

		$this->View()->assign(array('success' => true, 'data' => $data));
	}
	
	public function getCountriesAction()
	{
		$sql = "
		SELECT
			id,
			countryname AS name
		FROM
			s_core_countries";
		$data = Shopware()->Db()->fetchAll($sql);

		$this->View()->assign(array('success' => true, 'data' => $data));
	}
	
	public function getPaymentStatesAction()
	{
		$sql = "
		SELECT
			s.id AS id,
			s.description AS name
		FROM
			s_core_states s
		WHERE
			s.group = 'payment'
		ORDER BY s.position";
		$data = Shopware()->Db()->fetchAll($sql);
		
		$this->View()->assign(array('success' => true, 'data' => $data));
	}
	
	public function getOrderStatesAction()
	{
		$sql = "
		SELECT
			s.id AS id,
			s.description AS name
		FROM
			s_core_states s
		WHERE
			s.group = 'state'
		ORDER BY s.position";
		$data = Shopware()->Db()->fetchAll($sql);

		$this->View()->assign(array('success' => true, 'data' => $data));
	}

	public function getCarriersAction()
	{
		$request = $this->Request();
		$account = $request->getParam('account');

		$data = $this->externalOrderBase->getCarrierStore($account);

		$this->View()->assign(array('success' => true, 'data' => $data));
	}
}