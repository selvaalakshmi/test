<?php
namespace BrandCrockImageListingSlider\Subscriber;
use Enlight\Event\SubscriberInterface;
class ListingImageSlider implements SubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Listing' => 'onFrontendPostDispatchSecure',
            'Enlight_Controller_Action_PreDispatch_Widgets_Listing' => 'onFrontendPostDispatchWidgetListing'
        ];
    }
    public function onFrontendPostDispatchWidgetListing(\Enlight_Event_EventArgs $args)
    {
        $subject = $args->getSubject();
        $view = $subject->View();
        $mediaService = Shopware()->Container()->get('shopware_media.media_service');
     	 if ($subject->Request()->getActionName() == 'listingCount') {
             $sCategoryId = (int)$subject->Request()->getParam('sCategory');
             

              $ImageSliderQuery = "  select r.articleID 'articles_details_id', ai.* 
                              from  s_articles_img ai, s_articles_categories_ro r  
                              where r.articleID = ai.articleID 
                              and r.categoryID = " . $sCategoryId;
                              

                $catImageFetchData = Shopware()->Db()->fetchAll($ImageSliderQuery);
            
             foreach ($catImageFetchData as $item) {
             //var_dump($item);
              $articleImages[$item['articles_details_id']][] = $mediaService->getUrl('media/image/' . $item['img'] . "." . $item['extension']);
                //$articleImages[$item['ordernumber']][] = $mediaService->getUrl('media/image/' . $item['img'] . "." . $item['extension']);
             }
             //var_dump($articleImages);die();
             $view->assign('articleImages', $articleImages);

         }
    }
    public function onFrontendPostDispatchSecure(\Enlight_Event_EventArgs $args)
    {

        $controller = $args->get('subject');
        $view = $controller->View();
        $subject = $args->getSubject();

		$mediaService = Shopware()->Container()->get('shopware_media.media_service');
        $bcghTemplateVariable = $view->Template()->getTemplateVars();


		$categoryName =  $bcghTemplateVariable['sBreadcrumb'][0]['name'];
		$CategoryID = $bcghTemplateVariable['sCategoryContent']['id'];

        $totCatCounts = "select distinct articleID from s_articles_categories_ro where categoryID = '" . $CategoryID. "'";
        $fetchCatCount = Shopware()->Db()->fetchAll($totCatCounts);
        $view->assign('fetchCatCount', count($fetchCatCount));

		

		if ($subject->Request()->getActionName() == 'index') {
            foreach ($bcghTemplateVariable['sArticles'] as $item) {
                $articleId = $item['articleID'];
                $ImageSliderQuery = "  select a.id 'articles_details_id', ai.* 
				              from  s_articles_img ai, s_articles a 
				              where a.id = ai.articleID 
				              and a.id = " . $articleId;

                $fetchImageSlidersData = Shopware()->Db()->fetchAll($ImageSliderQuery);

                foreach ($fetchImageSlidersData as $fetchImageSliderData) {
                    $fetchImageSliderData['image'] = $mediaService->getUrl('media/image/' . $fetchImageSliderData['img'] . '.' . $fetchImageSliderData['extension']);
                    $bcghImage[] = $fetchImageSliderData['image'];
                    $sendArrayImage[] = $fetchImageSliderData;
                }
            }
            $view->assign('sendArrayImage', $sendArrayImage);
			      $view->assign('categoryName', $categoryName);

        }
    }


}



