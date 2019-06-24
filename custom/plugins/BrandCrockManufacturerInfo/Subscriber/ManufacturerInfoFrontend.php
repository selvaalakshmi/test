<?php

namespace BrandCrockManufacturerInfo\Subscriber;

use Enlight\Event\SubscriberInterface;

class ManufacturerInfoFrontend implements SubscriberInterface
{
    private $pluginName;
    private $pluginDir;

    public function __construct($pluginName, $pluginDir)
    {
        $this->pluginName = $pluginName;
        $this->pluginDir = $pluginDir;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Controller_Action_PreDispatch_Frontend' => 'onFrontendPreDispatch',
            'Enlight_Controller_Action_PostDispatch_Frontend_Detail' => 'onFrontendPostDispatchDetail'

        );
    }
   
        public function onFrontendPostDispatchDetail(\Enlight_Event_EventArgs $args)
        {
        /* @var $controller \Enlight_Controller_Action */
        $request = $args->getRequest();
        $controller = $args->getSubject();
        $view = $controller->View();

        $midetailTemplateVars = $view->Template()->getTemplateVars();
        $miorderNumber = $midetailTemplateVars['sArticle']['ordernumber'];
        $micontext = Shopware()->Container()->get('shopware_storefront.context_service')->getShopContext();
        $milangSnippets = substr($micontext->getShop()->getLocale()->getLocale(), 0, 5);
		$micurrentHttp = $request->getScheme() . '://';
        $mibasePath = Shopware()->Container()->get('Shop')->getBasePath();
        if(!empty($mibasePath)){
            $mishopUrl = $micurrentHttp . Shopware()->Config()->get('sHOST') . $mibasePath . '/files/Manufacturer-Img/';
        }else{
            $mishopUrl = $micurrentHttp . Shopware()->Config()->get('sHOST') . '/files/Manufacturer-Img/';
        }

        $miDataQuery = "select * from bcgh_manufacturer_details where  active = 1 and ordernumber  = '" . $miorderNumber . "' and language = '" .$milangSnippets ."' order by position asc";
        $miFetchArticlesData = Shopware()->Db()->fetchAll($miDataQuery);
        
		$miCount = "select count(*) from bcgh_manufacturer_details where ordernumber  = '" . $miorderNumber . "'";
        
		$miCountData = Shopware()->Db()->fetchOne($miCount);
       

        $view->assign('miCountData', $miCountData);

        $view->assign('miFetchArticlesData', $miFetchArticlesData);
		$view->assign('mishopUrl', $mishopUrl);
			

        }

    }