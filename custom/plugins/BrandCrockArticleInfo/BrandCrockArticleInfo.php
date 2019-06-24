<?php
/**
 * Plugin file (Bootstrap)
 *
 * Copyright (C) BrandCrock GmbH. All rights reserved
 *
 * If you have found this script useful a small
 * recommendation as well as a comment on our
 * home page(https://brandcrock.com/)
 * would be greatly appreciated.
 *
 * @author       BrandCrock
 * @package      BrandCrockArticleInfo
 */
 
 namespace BrandCrockArticleInfo;
 
 use Shopware\Components\Plugin;
 use Shopware\Components\Random;

class BrandCrockArticleInfo extends Plugin
{
	//~ public static function getSubscribedEvents()
	//~ {
		//~ return [
            //~ 'Shopware_Controllers_Frontend_Detail::indexAction::after' => 'onListing',
            //~ 'Enlight_Controller_Action_PreDispatch' => 'onTemplate',
        //~ ];
	//~ }
	 //~ public function onTemplate(\Enlight_Event_EventArgs $args){
		
			//~ $view     = $args->getSubject()->View();
		    //~ $view->addTemplateDir(__DIR__ . '/Resources/views/');
	//~ }
	//~ public function onListing(\Enlight_Event_EventArgs $args)
    //~ {
		//~ $view     = $args->getSubject()->View();
		//~ $artid = Shopware()->Front()->Request()->sArticle;
		
		//~ $number = Shopware()->Front()->Request()->number; 
		//~ $where = ($number) ?   "ordernumber= '$number'" : "id= '$artid'";
		//~ $sql = "select articleID from s_articles_details where $where";
		
		//~ $connection = Shopware()->Container()->get('dbal_connection');
		//~ $result = $connection->fetchAll($sql);
		//~ print_r($result);
		//~ exit;
		//~ $view->assign('result', $result);
		
	//~ }
}
