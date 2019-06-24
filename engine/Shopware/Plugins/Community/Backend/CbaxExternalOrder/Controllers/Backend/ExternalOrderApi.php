<?php

use Shopware\Components\CSRFWhitelistAware;

class Shopware_Controllers_Backend_ExternalOrderApi extends Enlight_Controller_Action implements CSRFWhitelistAware
{
	private $plugin;
	
    private $config;
	
	public function init()
	{
		$this->plugin = Shopware()->Plugins()->Backend()->CbaxExternalOrder();
        $this->config = $this->plugin->Config();
		
		Shopware()->Plugins()->Controller()->ViewRenderer()->setNoRender();
		
		if (in_array($this->Request()->getActionName(), array('setStatus', 'createShopwareOrder'))) {
            Shopware()->Plugins()->Backend()->Auth()->setNoAuth();
        }
	}
	
	public function setStatusAction()
	{
		try 
		{
			$request = $this->request;
			$key = trim($request->key);
			
			if ($this->config->cron_key == $key)
			{
				$orders = $this->plugin->runSetStatus();
				
				if ($orders > 0)
				{
					echo $orders.' Bestellungen aktualisiert';
				}
				else
				{
					echo 'Set Shipping Status - Nothing to do';
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
		catch(Exception $e)
		{
			echo('Fehler');
			//echo($e->getMessage().'<br />');
			//echo($e->getTraceAsString());
		}
	}
	
	public function createShopwareOrderAction()
	{
		try 
		{
			$request = $this->request;
			$key = trim($request->key);
			
			if ($this->config->cron_key == $key)
			{
				$orders = $this->plugin->runCreateShopwareOrder();
				
				if ($orders > 0)
				{
					echo $orders.' Shopware Bestellungen generiert';
				}
				else
				{
					echo 'Shopware Orders Generated - Nothing to do';
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
		catch(Exception $e)
		{
			echo('Fehler');
			//echo($e->getMessage().'<br />');
			//echo($e->getTraceAsString());
		}
	}
	
	/**
     * Returns a list with actions which should not be validated for CSRF protection
     *
     * @return string[]
     */
    public function getWhitelistedCSRFActions()
    {
		return array('setStatus', 'createShopwareOrder');
    }
	
	// /backend/ExternalOrderApi/setStatus?key=123
	// /backend/ExternalOrderApi/createShopwareOrder?key=123
}