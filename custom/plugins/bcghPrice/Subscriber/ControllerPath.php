<?php

namespace bcghPrice\Subscriber;

use Enlight\Event\SubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ControllerPath implements SubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var \Enlight_Template_Manager
     */
    protected $template;

    /**
     * @var string
     */
    protected $pluginDir;

    /**
     * @var string
     */
    protected $viewDir;

    /**
     * ControllerPath constructor.
     *
     * @param ContainerInterface        $container
     * @param \Enlight_Template_Manager $template
     * @param                           $pluginDir
     * @param                           $viewDir
     */
    public function __construct(
        ContainerInterface $container,
        \Enlight_Template_Manager $template,
        $pluginDir,
        $viewDir
    ) {
        $this->container = $container;
        $this->template  = $template;
        $this->pluginDir = $pluginDir;
        $this->viewDir   = $viewDir;
    }

    /**
     * Returning an array with subscribed events we need, since this is only for controllerpaths hence we will only
     * subscriber to give our controllerpaths to Shopware
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Controller_Dispatcher_ControllerPath_Frontend_bcghPrice' => 'onGetControllerPathFrontend',
        );
    }


    /**
     * Register the frontend controller
     *
     * @param   \Enlight_Event_EventArgs $args
     * @return  string
     * @Enlight\Event Enlight_Controller_Dispatcher_ControllerPath_Frontend_bcFom     */
    public function onGetControllerPathFrontend(\Enlight_Event_EventArgs $args)
    {
        $this->template->addTemplateDir($this->viewDir);
        return $this->pluginDir . '/Controllers/Frontend/bcghPrice.php';
    }
}
