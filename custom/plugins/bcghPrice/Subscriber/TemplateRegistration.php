<?php

namespace bcghPrice\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Template_Manager;

class TemplateRegistration implements SubscriberInterface
{
    /**
     * @var Enlight_Template_Manager
     */
    private $templateManager;

    /**
     * @var string
     */
    private $pluginBaseDirectory;

    /**
     * @param string                   $pluginBaseDirectory
     * @param Enlight_Template_Manager $templateManager
     */
    public function __construct($pluginBaseDirectory, Enlight_Template_Manager $templateManager)
    {
        $this->templateManager = $templateManager;
        $this->pluginBaseDirectory = $pluginBaseDirectory;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatch' => 'onPreDispatch',
        ];
    }

    public function onPreDispatch()
    {
        $this->templateManager->addTemplateDir($this->pluginBaseDirectory . '/Resources/views');
    }
}
