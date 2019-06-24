<?php

namespace BrandCrockMultiArticleTabs\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Bundle\MediaBundle;
use Enlight_Controller_Request_Request;

class MultiArticleTabsFrontend implements SubscriberInterface
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



    public function onFrontendPreDispatch(\Enlight_Event_EventArgs $args)
    {
        /** @var $controller \Enlight_Controller_Action */

        $controller = $args->getSubject();
        $view = $controller->View();
        $view->addTemplateDir($this->pluginDir . '/Resources/View/');
    }

    public function onFrontendPostDispatchDetail(\Enlight_Event_EventArgs $args)
    {
        /** @var $controller \Enlight_Controller_Action */
        $request = $args->getRequest();
        $controller = $args->getSubject();
        $view = $controller->View();
        $currentHttpPdf = $request->getScheme() . '://';
        $basePathPdf = Shopware()->Container()->get('Shop')->getBasePath();
        if(!empty($basePathPdf)){
            $ShopUrl = $currentHttpPdf . Shopware()->Config()->get('sHOST') . $basePathPdf . '/';
        }else{
            $ShopUrl = $currentHttpPdf . Shopware()->Config()->get('sHOST') . '/';
        }
        $detailTemplateVars = $view->Template()->getTemplateVars();
        $product_desc = $detailTemplateVars['sArticle']['bcgh_desc'];
        $product_Info = $detailTemplateVars['sArticle']['bcgh_product_info'];

        $view->assign('product_desc', $product_desc);
        $view->assign('product_Info', $product_Info);

        $orderNumber = $detailTemplateVars['sArticle']['ordernumber'];
        $context = Shopware()->Container()->get('shopware_storefront.context_service')->getShopContext();
        $langSnippets = substr($context->getShop()->getLocale()->getLocale(), 0, 5);

        $PdfDataQuery = "select * from bcgh_pdf_details where  active = 1 and orderNumber  = '" . $orderNumber . "' and language = '" .$langSnippets ."' order by position asc";
        $FetchArticlesData = Shopware()->Db()->fetchAll($PdfDataQuery);

        $PdfCountQuery = "SELECT count(ordernumber) as countid from bcgh_pdf_details where   active = 1 and orderNumber  = '" . $orderNumber . "'  and language = '" .$langSnippets ."' ";

        $FetchCountsData = Shopware()->Db()->fetchRow($PdfCountQuery);
        $view->assign('FetchArticlesData', $FetchArticlesData);
        $view->assign('FetchCountsData', $FetchCountsData);
        $view->assign('PdfShopUrlData', $ShopUrl);


        //Faq Data
        $FaqDataQuery = "select * from bcgh_faq_details where orderNumber  = '" . $orderNumber . "' and active = 1  and language = '" .$langSnippets ."' order by position asc";
        $FetchFaqsData = Shopware()->Db()->fetchAll($FaqDataQuery);
        $view->assign('FetchFaqsData', $FetchFaqsData);

        //Faq Count
        $FaqCountQuery = "SELECT count(ordernumber) as countid from bcgh_faq_details where   active = 1 and orderNumber  = '" . $orderNumber . "'  and language = '" .$langSnippets ."' ";
        $FetchFaqCountsData = Shopware()->Db()->fetchRow($FaqCountQuery);
        $view->assign('FetchFaqCountsData', $FetchFaqCountsData);




    }
}
