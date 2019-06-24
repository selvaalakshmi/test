<?php

namespace CompraSuggestionSearch\Subscriber;

use CompraSuggestionSearch\Compatibility\ExpandLegacyStructConverter;
use Enlight\Event\SubscriberInterface;
use Shopware\Bundle\SearchBundle\ProductSearchResult;

class AjaxSearch implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginDir;

    /**
     * @var \Enlight_Controller_Action
     */
    private $controller;

    /**
     * @var \Enlight_Controller_Request_Request
     */
    private $request;

    /**
     * @var \Enlight_View_Default
     */
    private $view;

    /**
     * @var \Shopware_Components_Config
     */
    private $config;

    /**
     * @var $categories array
     */
    private $categories;

    /**
     * AjaxSearch constructor.
     * @param $config
     */

    // Define plugin name for template config definition
    private $pluginDef;

    public function __construct($pluginDir)
    {
        $this->pluginDir = $pluginDir;
        $this->config = Shopware()->Config();
        $this->pluginDef = "CompraSuggestionSearch";
    }

    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Controllers_Frontend_AjaxSearch::indexAction::after' => 'onAfterAjaxSearch',
            'Enlight_Bootstrap_AfterInitResource_legacy_struct_converter' => 'afterConvertProductStruct',
            'Enlight_Controller_Action_PreDispatch' => 'onPreDispatch',
            'Theme_Compiler_Collect_Plugin_Less' => 'onThemeCompilerCollectPluginLess'
        ];
    }

    public function onThemeCompilerCollectPluginLess(\Enlight_Event_EventArgs $args)
    {
        return new \Shopware\Components\Theme\LessDefinition(
            [],
            [
                $this->pluginDir. '/Resources/views/frontend/_public/src/less/all.less'
            ],
            $this->pluginDir
        );
    }

    public function afterConvertProductStruct()
    {
        $coreService = Shopware()->Container()->get('legacy_struct_converter');
        $convertService = new ExpandLegacyStructConverter($coreService);
        Shopware()->Container()->set('legacy_struct_converter',$convertService);
    }

    public function onPreDispatch(\Enlight_Event_EventArgs $args)
    {
        $controller = $args->get('subject');
        $view = $controller->View();
        $view->addTemplateDir($this->pluginDir . '/Resources/views');
    }

    public function onAfterAjaxSearch(\Enlight_Hook_HookArgs $args)
    {
        // Get all configurations.
        $this->controller = $args->getSubject();
        $this->request = Shopware()->Front()->Request();
        $this->view = $this->controller->View();

        $supplier = [];
        $categories = [];
        $searchService = null;

        $context = $this->controller->get('shopware_storefront.context_service')->getProductContext();
        /** @var $criteria Criteria */
        $criteria = $this->controller->get('shopware_search.store_front_criteria_factory')
            ->createAjaxSearchCriteria($this->request, $context);

        // set criteria so that searches for all search results
        if ($this->config->getByNamespace('CompraSuggestionSearch', 'suggestions_active_elasticsearch')) {
            $criteria->limit(10000);        // increase limit number to elastic search value
        } else {
            $criteria->limit(1000000000);   // increase limit number because of shopware issue/fix SW-17272
        }

        /**@var $result ProductSearchResult */
        $result = $this->controller->get('shopware_search.product_search')->search($criteria, $context);
        $articles = $this->convertProducts($result);

        // Get Categories and Suppliers
        foreach ($articles as $article)
        {
            if (array_key_exists('categories', $article))
            {
                // Put all categories in an array
                /** @var $category Struct\Category */
                foreach ($article['categories'] as $category)
                {
                    $categoryID = $category->getId();
                    // Check if category with ID already exist
                    if (isset($categories[$categoryID]))
                    {
                        // Count number of products with same category
                        $categories[$categoryID]['count']++;
                    } else {
                        //Set a new category
                        $categories[$categoryID] = array(
                            'name' => $category->getName(),
                            'id' => $categoryID,
                            'parent_id' => $category->getParentId(),
                            'count' => 1);
                    }
                }
            }

            // Put all supplier in an array
            $supplierID = $article['supplierID'];
            // Check if supplier with ID already exist
            if (isset($supplier[$supplierID]))
            {
                // Count number of products with same supplier
                $supplier[$supplierID]['count']++;
            } else {
                // Set a new supplier
                $supplier[$supplierID] = [
                    'name' => $article['supplierName'],
                    'id' => $supplierID,
                    'count' => 1];
            }
        }
        // Sort the suppliers to number of results
        $this->sortArray($supplier,'count');

        // Set Categories
        $this->categories = $categories;

        // check for subshop categories from another shop and remove them
        $rootCategory = Shopware()->Shop()->getCategory();
        $filteredCategories = [];

        foreach ($categories as $category)
        {
            $found = false;
            $categoryObject = Shopware()->Models()->getRepository('Shopware\Models\Category\Category')->findOneBy(['id' => $category['id']]);
            if ($categoryObject) {
                $found = ($categoryObject->isChildOf($rootCategory) || $categoryObject->getId() === $rootCategory->getId());
            }
            if ($found)
            {
                $filteredCategories[$categoryObject->getId()] = $category;
            }
        }
        $categories = $filteredCategories;

        //Check if category is a parent of an other category
        $parentCategories = [];
        foreach ($categories as $category)
        {
            $categoryID = $category['id'];
            if (!array_key_exists($categoryID,$parentCategories))
            {
                foreach ($categories as $cat)
                {
                    if ($categoryID != $cat['id'] && $categoryID === $cat['parent_id'])
                    {
                        $parentCategories[$categoryID] = $category;
                    }
                }
            }
        }

        // Remove the Parentcategories
        $tailCategories = array_diff_key($categories, $parentCategories);

        // Sort the categories to number of results
        $this->sortArray($tailCategories,'count');

        // Check config,number of displayed categories
        if ($this->config->get('categories_number_results') >= 1)
        {
            $tailCategories = array_slice($tailCategories, 0, $this->config->get('categories_number_results'),true);
        } else {
            $tailCategories = array_slice($tailCategories, 0, 1,true);
        }

        // Check if double categories exists
        $tailCategories = $this->checkDoubles($tailCategories);

        // Convert tree for the display
        $tailCategoriesPath = $this->getCategoryPath($tailCategories);

        // Build category path for the display
        $categoryPath = [];
        foreach ($tailCategoriesPath as $key => $categories)
        {
            // Get hole categorypath for the hover display
            $linkTitle = implode(' > ',$categories);
            if (\count($categories) > 2)
            {
                // Abbreviation of the path
                $categories = array_values($categories);
                $start = $categories[0];
                $end = $categories[count($categories)-1];
                $name = $start. " > ... > ". $end;
            } else {
                $name = $linkTitle;
            }
            $categoryPath[$key] = ['linkTitle' => $linkTitle, 'name' => $name];
        }

        // Check Configuration
        if ($this->config->get('manufacturer_number_results') >= 1)
        {
            $supplier = array_slice($supplier, 0, $this->config->get('manufacturer_number_results'));
        } else {
            $supplier = array_slice($supplier, 0, 1);
        }

        $useSuggestionSearch = $this->config->getByNamespace($this->pluginDef,'suggestions_active_suggestion_search');
        $showManufacturer = $this->config->getByNamespace($this->pluginDef,'suggestions_manufacturer');
        $showCategories = $this->config->getByNamespace($this->pluginDef,'suggestions_categories');
        $showCategoriesWithFiler =$this->config->getByNamespace($this->pluginDef,'suggestions_categories_with_filter') ;
        $showManufacturerWithFilter = $this->config->getByNamespace($this->pluginDef,'suggestions_manufacturer_with_filter');
        $showSearchSuggestions = $this->config->getByNamespace($this->pluginDef,'suggestions_did_you_mean');
        $categoriesLinkToSearchResults = $this->config->getByNamespace($this->pluginDef,'suggestions_categories_link_to_search_results');
        $manufacturerLinkToSearchResults = $this->config->getByNamespace($this->pluginDef,'suggestions_manufacturer_link_to_search_results');

        // Set View
        $this->view->assign('compraSuggestionSearch', [
            'useSuggestionSearch' => $useSuggestionSearch,
            'showManufacturer' => $showManufacturer,
            'showCategories' => $showCategories,
            'showCategoriesWithFilter' => $showCategoriesWithFiler,
            'showManufacturerWithFilter' => $showManufacturerWithFilter,
            'categoriesLinkToSearchResults' => $categoriesLinkToSearchResults,
            'manufacturerLinkToSearchResults' => $manufacturerLinkToSearchResults,
            'showSearchSuggestions' => $showSearchSuggestions,
            'compraCategories' => $tailCategories,
            'compraCategoriesPath' => $categoryPath,
            'compraSuppliers' => $supplier
        ]);
    }

    /**
     * @param  ProductSearchResult $result
     * @return array
     * @throws \Exception
     */
    private function convertProducts($result)
    {
        $articles = array();
        foreach ($result->getProducts() as $product)
        {
            $article = $this->controller->get('legacy_struct_converter')->convertListProductStruct($product);
            $articles[] = $article;
        }
        if (empty($articles))
        {
            return null;
        }
        return $articles;
    }

    /**
     * Method to build a tree from double name categories
     * @param $categories array
     * @return array
     */
    public function checkDoubles($categories)
    {
        // get all doubles
        $doubleCategories = $this->getDoubles($categories);
        $double = [];
        foreach ($doubleCategories as $doubles)
        {
            if (!(array_key_exists($doubles['id'], $double)))
            {
                // get the same doubles
                $double = $this->getDoubles($doubleCategories, $doubles['name']);
                $parents = $this->setParents($double);
                // add parents to variable $double
                $double = $parents[0];
                // check if parents are different
                $cat = $this->checkDoubles($parents[1]);
                // build category tree
                foreach ($double as &$replace)
                {
                    $replaceID = $replace['parent_id'];
                    $replace['parent'] = [$replaceID => $cat[$replaceID]];
                }
                $categories = array_replace($categories, $double);
            }
        }
        return $categories;
    }

    /**
     * Method to get categories with the same name
     * @param $categories array
     * @param $name string
     * @return array
     */
    public function getDoubles ($categories, $name = null)
    {
        $doubleCategories = null;
        foreach ($categories as $cats)
        {
            foreach ($categories as $category)
            {
                if ($cats['id'] != $category['id'] && $cats['name'] === $category['name'] &&(($name === $cats['name'] || $name === null)))
                {
                    $doubleCategories[$category['id']] = $category;
                }
            }
        }
        return $doubleCategories;
    }

    /**
     * Method to set the parent to a category
     * @param $doubles array
     * @return array
     */
    public function setParents($doubles)
    {
        $parents = [];
        // sets a parent-parameter to the $doubles-array
        foreach ($doubles as &$term)
        {
            $termID = $term['parent_id'];
            $term['parent'] = [$termID => $this->getCategory($termID)];
            $parents[$termID] = $this->getCategory($termID);
        }
        unset($term);
        return [$doubles, $parents];
    }

    /**
     * Method to get category path from tail categories
     * @param $categories array
     * @return array
     */
    public function getCategoryPath($categories)
    {
        $tailCategories = null;
        // Get category path for each category
        foreach ($categories as $category)
        {
            $path = null;
            $tailCategories[$category['id']] = $this->getCategoryPathPart($category, $path);
        }
        return $tailCategories;
    }

    /**
     * Method to built category path
     * @param $data array
     * @param $path array
     * @return mixed
     */
    public function getCategoryPathPart($data, $path)
    {
        if (array_key_exists('parent', $data))
        {
            $path = $this->getCategoryPathPart($data['parent'][$data['parent_id']], $path);
            $path[$data['id']] = $data['name'];
        } else {
            $path[$data['id']] = $data['name'];
        }
        return $path;
    }

    /**
     * @param $id int
     * @return array
     */
    public function getCategory($id)
    {
        return $this->categories[$id];
    }

    /**
     * Method to sort the array to the number of results
     * @param array $array
     * @param string $key
     */
    private function sortArray (&$array, $key)
    {
        $sort= [];
        $ret= [];
        reset($array);
        foreach ($array as $k => $var)
        {
            $sort[$k]=$var[$key];
        }
        arsort($sort);
        foreach ($sort as $k => $var)
        {
            $ret[$k]=$array[$k];
        }
        $array=$ret;
    }



}