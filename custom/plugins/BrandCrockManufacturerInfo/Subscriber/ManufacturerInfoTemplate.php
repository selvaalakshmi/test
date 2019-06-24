<?php

namespace BrandCrockManufacturerInfo\Subscriber;
use Enlight\Event\SubscriberInterface;


class ManufacturerInfoTemplate implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginDirectory;

    /**
     * @var \Enlight_Template_Manager
     */
    private $templateManager;

    /**
     * @param $pluginDirectory
     * @param \Enlight_Template_Manager $templateManager
     */
    public function __construct($pluginDirectory, \Enlight_Template_Manager $templateManager)
    {
        $this->pluginDirectory = $pluginDirectory;
        $this->templateManager = $templateManager;
    }
    /**
     * {@inheritdoc}
     */

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'onPreDispatch'
          	
        ];
    }
	 /**
     * @param \Enlight_Controller_ActionEventArgs $args
     */
    public function onPreDispatch()
    {
		
        $this->templateManager->addTemplateDir($this->pluginDirectory . '/Resources/views');
		
    }
   
}