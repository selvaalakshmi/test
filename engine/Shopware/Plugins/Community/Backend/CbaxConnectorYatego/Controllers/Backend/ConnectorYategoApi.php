<?php

use Shopware\Components\CSRFWhitelistAware;

class Shopware_Controllers_Backend_ConnectorYategoApi extends Enlight_Controller_Action implements CSRFWhitelistAware
{
	private $plugin;
	
    private $config;

	private $cron_key;
	
	public function init()
	{
		$this->plugin = Shopware()->Plugins()->Backend()->CbaxConnectorYatego();
        $this->config = $this->plugin->Config();

		$this->cron_key = Shopware()->Plugins()->Backend()->CbaxExternalOrder()->Config()->cron_key;
		
		Shopware()->Plugins()->Controller()->ViewRenderer()->setNoRender();
		
		if (in_array($this->Request()->getActionName(), array('importOrder', 'statusSend'))) {
            Shopware()->Plugins()->Backend()->Auth()->setNoAuth();
        }
	}

	public function importOrderAction()
	{
		$request = $this->request;
		$key = trim($request->key);
		
		if ($this->cron_key == $key)
		{
			$orders = $this->plugin->runAutoImport();
			
			if ($orders > 0)
			{
				echo $orders.' Bestellungen importiert';
			}
			else
			{
				echo 'Import - Nothing to do';
			}
		}
		else
		{
			$this->Response()
                ->clearHeaders()
                ->setHttpResponseCode(403)
                ->appendBody("Forbidden");
            return;
		}
	}
	
	public function statusSendAction()
	{
		$request = $this->request;
		$key = trim($request->key);
		
		if ($this->cron_key == $key)
		{
			echo 'Kein Abgleich über Yatego möglich!';
		}
		else
		{
			$this->Response()
                ->clearHeaders()
                ->setHttpResponseCode(403)
                ->appendBody("Forbidden");
            return;
		}
	}
	
	/**
     * Returns a list with actions which should not be validated for CSRF protection
     *
     * @return string[]
     */
    public function getWhitelistedCSRFActions()
    {
        return array('importOrder', 'statusSend');
    }
	
	// /backend/ConnectorYategoApi/statusSend?key=123
	// /backend/ConnectorYategoApi/importOrder?key=123
}