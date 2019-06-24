<?php


namespace BrandCrockSwitchListingFeature;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class BrandCrockSwitchListingFeature extends Plugin {
    
     /**
     * Adds the widget to the database and creates the database schema.
     *
     * @param Plugin\Context\InstallContext $installContext
     */
    public function install(InstallContext $installContext)
    {
        parent::install($installContext);

    }
    
    /**
     * Remove widget and remove database schema.
     *
     * @param Plugin\Context\UninstallContext $uninstallContext
     */
    public function uninstall(UninstallContext $uninstallContext)
    {
        parent::uninstall($uninstallContext);

    }

    public function activate(ActivateContext $activateContext)
    {
        // on plugin activation clear the cache
        $activateContext->scheduleClearCache(ActivateContext::CACHE_LIST_ALL);
    }

    public function deactivate(DeactivateContext $deactivateContext)
    {
        // on plugin deactivation clear the cache
        $deactivateContext->scheduleClearCache(DeactivateContext::CACHE_LIST_ALL);
    }
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Listing' => 'onFrontendListing',
            //~ 'Enlight_Controller_Action_PreDispatch_Widgets_Listing' => 'onFrontendPostDispatchWidgetListing',
            'Enlight_Controller_Action_PostDispatch_Frontend_Listing' => 'onFrontendPostDispatchWidgetListing',
        ];
    }
    public function onFrontendPostDispatchWidgetListing(\Enlight_Event_EventArgs $args)
    {
        /* @var \Shopware_Controllers_Widgets_Listing $subject */
        $subject = $args->getSubject();
        $view = $subject->View();

        if (Shopware()->Session()->offsetExists('productLayoutClass' ) && $subject->Request()->getActionName() == 'listingCount'){
            $view->assign('sts',1);
            $view->assign('productLayoutClass',Shopware()->Session()->offsetGet('productLayoutClass' ));
        }
    }

     /**
     * @param \Enlight_Event_EventArgs $args
     */

    public function onFrontendListing(\Enlight_Event_EventArgs $args)
    {
        /** @var \Shopware_Controllers_Frontend_Register $subject */
        $request = $args->getRequest();
        $response = $args->getResponse();
//~ echo __line__; exit;
        $subject = $args->getSubject();
        $view = $subject->View();
        $view->addTemplateDir($this->getPath().'/Resources/views');


        $TemplateVariables = $view->Template()->getTemplateVars();

        $currentHttp = $request->getScheme() . '://';
        $bclistbasePath = Shopware()->Container()->get('Shop')->getBasePath();
  $url = sprintf('%s://%s%s',
                $request->getScheme(),
                $request->getHttpHost(),
                $request->getRequestUri()
            );
        if(!empty($bclistbasePath)){

            $bclistShopUrl = $currentHttp . Shopware()->Config()->get('sHOST') . $bclistbasePath . '/custom/plugins/BrandCrockSwitchListingFeature/Resources/views/images/' ;

        }else{

            $bclistShopUrl = $currentHttp . Shopware()->Config()->get('sHOST') . '/custom/plugins/BrandCrockSwitchListingFeature/Resources/views/images/';

        }

        $CategoryContent = $TemplateVariables['sCategoryContent'];
        $categoryID = $CategoryContent['id'];


        //Listing Layout Change Parameter
        $sts = $request->getParam('sts');
        $layout = $request->getParam('listlayout');
       Shopware()->Session()->offsetUnset('productLayoutClass');

        if(($sts == 1) && ($subject->Request()->getActionName() == 'index')){
            $productLayoutClass = $layout;
           

            $view->assign('sts',$sts);
            $view->assign('productLayoutClass',$productLayoutClass);

            Shopware()->Session()->offsetSet('productLayoutClass', $productLayoutClass);
        
        //~ echo '<pre>';
        //~ $categoryContent = Shopware()->Modules()->Categories()->sGetCategoryContent($categoryID);

        //~ $TemplateVariables['sCategoryContent']['productBoxLayout'] = $productLayoutClass;
        //~ ); exit;
        //~ $view->assign($TemplateVariables);

		if($productLayoutClass == 'list' && $TemplateVariables['sCategoryContent']['productBoxLayout'] == 'list') {
			$url = sprintf('%s://%s%s',
			$request->getScheme(),
			$request->getHttpHost(),
			$request->getRequestUri()
			);		
			$response->setRedirect($url);
		}
        
        //~ print_r($TemplateVariables); exit;
	}
        
        $view->assign('categoryID',$categoryID);
        $view->assign('bclistShopUrl', $bclistShopUrl);

    }

}
?>
