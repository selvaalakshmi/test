<?php
namespace BrandCrockSerachVariant;
use Shopware\Components\Plugin;
use Shopware\Bundle\SearchBundle\ProductSearchResult;
use Shopware\Bundle\SearchBundle\SearchTermPreProcessorInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
class BrandCrockSerachVariant extends Plugin
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Controllers_Frontend_Search::defaultSearchAction::after' => 'defaultSearchActionAfter',
            'Shopware_Controllers_Frontend_AjaxSearch::indexAction::after' => 'indexActionAfter',
        ];
    }
	public function indexActionAfter(\Enlight_Event_EventArgs $args)
	{
		$Request = $args->getSubject()->Request();
        $term= $Request->getParam('sSearch', '');
        $view = $args->getSubject()->View();
        $products = $view->getAssign('sSearchResults')['sResults'];
        $sArticlesCount = $view->getAssign('sSearchResults')['sArticlesCount'];
         //~ exit;
      
             $product = [];
        foreach ($products as $k => $val) {
            if($val['sConfigurator']) {
                $needtoGet[] = $val['articleID'];
            }
        }
        foreach ($needtoGet as  $k => $val) {
            $ordernumbner[$k] =  self::getorderNumberOfvariants($val);
        }
        foreach ($ordernumbner as  $k => $val) {
            foreach($val as $key => $values) {
                $totalordernumber[]= $values;
            }
        }
        foreach ( $totalordernumber as $key => $value) {
            $number = $value['ordernumber'];
            $id = '';
            $categoryId = '';
            $selection = [];
            try {
                $product[$key] = Shopware()->Modules()->Articles()->sGetArticleById(
                $id,
                $categoryId,
                $number,
                $selection
                );
                $product[$key]['link'] = $product[$key]['linkDetailsRewrited'];
                $product[$key]['name'] = $product[$key]['articleName'] .' ' . $product[$key]['additionaltext'];
            } catch (\Exception $e) {
                $product = null;
            }

        }
        $total = array_merge($products,$product);
        $view->assign('sSearchResults',
            [
            'sResults' =>  $total,
            'sArticlesCount' => count($total),
            ]
        );
	}
    /**
     * Search product by order number
     *
     * @param string $search
     *
     * @return string|false
     */
    protected function searchFuzzyCheck($search)
    {
        /** @var Shopware_Components_Config $config */
        $config = Shopware()->Container()->get('config');
        if (!$config->get('activateNumberSearch')) {
            return false;
        }

        $minSearch = empty($config->sMINSEARCHLENGHT) ? 2 : (int) $config->sMINSEARCHLENGHT;
        $number = null;
        if (!empty($search) && strlen($search) >= $minSearch) {
            $sql = '
                SELECT DISTINCT articleID, ordernumber, s_articles.configurator_set_id
                FROM s_articles_details
                  INNER JOIN s_articles
                   ON s_articles.id = s_articles_details.articleID
                WHERE ordernumber = ?
                GROUP BY articleID
                LIMIT 2
            ';
            $products = Shopware()->Container()->get('db')->fetchAll($sql, [$search]);
            if ($products[0]['configurator_set_id']) {
                $number = $products[0]['ordernumber'];
            }

            $products = array_column($products, 'articleID');

            if (empty($products)) {
                $sql = "
                    SELECT DISTINCT articleID
                    FROM s_articles_details
                    WHERE ordernumber = ?
                    OR ? LIKE CONCAT(ordernumber, '%')
                    GROUP BY articleID
                    LIMIT 2
                ";
                $products = Shopware()->Container()->get('db')->fetchCol($sql, [$search, $search]);
            }
        }
        if (!empty($products) && count($products) == 1) {
            $sql = '
                SELECT ac.articleID
                FROM  s_articles_categories_ro ac
                INNER JOIN s_categories c
                    ON  c.id = ac.categoryID
                    AND c.active = 1
                    AND c.id = ?
                WHERE ac.articleID = ?
                LIMIT 1
            ';

            $products = Shopware()->Container()->get('db')->fetchCol($sql, [
                Shopware()->Container()->get('shop')->get('parentID'),
                $products[0],
            ]);
        }
        if (!empty($products) && count($products) == 1) {
            $assembleParams = [
                'sViewport' => 'detail',
                'sArticle' => $products[0],
            ];
            if ($number) {
                $assembleParams['number'] = $number;
            }

            return Shopware()->Container()->get('router')->assemble($assembleParams);
        }
    }

    public function defaultSearchActionAfter(\Enlight_Event_EventArgs $args)
    {
        $Request = $args->getSubject()->Request();
        $term= $Request->getParam('sSearch', '');
        $dirs = $args->getReturn();
        $view = $args->getSubject()->View();
        $products                              = $view->getAssign('sSearchResults')['sArticles'];
        if($products == null || empty($products)) {
            $location = $this->searchFuzzyCheck($term);
            if (!empty($location)) {
                $context = Shopware()->Container()->get('shopware_storefront.context_service')->getShopContext();

                $criteria = Shopware()->Container()->get('shopware_search.store_front_criteria_factory')
                ->createSearchCriteria($Request, $context);

                $result = Shopware()->Container()->get('shopware_search.product_search')->search($criteria, $context);
                $products = $this->convertProducts($result);;
            }
        }
            $product = [];
        foreach ($products as $k => $val) {
            if($val['sConfigurator']) {
                $needtoGet[] = $val['articleID'];
            }
        }
        foreach ($needtoGet as  $k => $val) {
            $ordernumbner[$k] =  self::getorderNumberOfvariants($val);
        }
        foreach ($ordernumbner as  $k => $val) {
            foreach($val as $key => $values) {
                $totalordernumber[]= $values;
            }
        }
        foreach ( $totalordernumber as $key => $value) {
            $number = $value['ordernumber'];
            $id = '';
            $categoryId = '';
            $selection = [];
            try {
                $product[$key] = Shopware()->Modules()->Articles()->sGetArticleById(
                $id,
                $categoryId,
                $number,
                $selection
                );
                $product[$key]['linkDetails'] = $product[$key]['linkDetailsRewrited'];
                $product[$key]['articleName'] = $product[$key]['articleName'] .' '. $product[$key]['additionaltext'];
                $product[$key]['name'] = $product[$key]['articleName'] .' ' . $product[$key]['additionaltext'];
            } catch (\Exception $e) {
                $product = null;
            }

        }
        $view->assign('sSearchResults',
            [
            'sArticles' => array_merge($products,$product),
            'sArticlesCount' => count(array_merge($products,$product)),
            ]
        );
    }
    public static function getorderNumberOfvariants($articleID)
    {
        return  Shopware()->Db()->fetchAll('
        SELECT ordernumber FROM s_articles_details WHERE kind = 2 and articleID = ?
        ', [$articleID]);
    }
    /**
     * @return array|null
     */
    private function convertProducts(ProductSearchResult $result)
    {
        $products = [];
        foreach ($result->getProducts() as $product) {
            $productArray = Shopware()->Container()->get('legacy_struct_converter')->convertListProductStruct($product);

            $products[] = $productArray;
        }

        if (empty($products)) {
            return null;
        }

        return $products;
    }
}
?>
