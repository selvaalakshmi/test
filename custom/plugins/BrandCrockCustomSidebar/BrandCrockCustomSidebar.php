<?php

namespace BrandCrockCustomSidebar;

use Shopware\Components\Plugin;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Shopware\Models\Article\Supplier;
/**
 * Shopware-Plugin BrandCrockCustomSidebar.
 */
class BrandCrockCustomSidebar extends Plugin
{

    /**
    * @param ContainerBuilder $container
    */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('brand_crock_custom_sidebar.plugin_name', $this->getName());
        $container->setParameter('brand_crock_custom_sidebar.plugin_dir', $this->getPath());
        parent::build($container);
    }

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Listing' => 'onFrontendListing'
        ];
    }

    public function onFrontendListing(\Enlight_Event_EventArgs $args)
    {
        /** @var \Shopware_Controllers_Frontend_Listing $subject */
        $subject = $args->getSubject();
        $view = $subject->View();
        $request = $subject->Request();

        $view->addTemplateDir($this->getPath() . '/Resources/views');

        $config = $this->container->get('shopware.plugin.cached_config_reader')->getByPluginName($this->getName());

        $sCategory = $request->getParam('sCategory');
        $category = $this->getParentCategory($sCategory);
        $pCategoryId = $category['id'];
        $sCategorydd = Shopware()->Modules()->Categories()->sGetWholeCategoryTree($pCategoryId);
		$categorysParent = Shopware()->Modules()->Categories()->sGetCategoryContent($sCategory);
		$path = $categorysParent['path']; 
		$pathIds = explode('|', $path);
		$view->activeMainCategoryId =$pathIds[2];
        foreach ($sCategorydd as $key => $value) {
            $firstLevel[] = $value['sub'];
            if(is_array($value['sub']) && $value['sub'] && !empty($value['sub'])) {
                foreach($value['sub'] as $k => $v) {
                    $subcategory[$v['id']] = $v['sub'];
                }
            }
        }

        if(empty($subcategory)) {
            $subcategory = $firstLevel;
        }
        $view->subofSubCategories = $subcategory;
        if(is_numeric($sCategory) && $sCategory > 0){
            $category = $this->getParentCategory($sCategory);
            $pCategoryId = $category['id'];
            $pCategoryName = $category['name'];

            $supplierCategories = $this->getSupplierCategories();
            $suppliers = $this->getSuppliers($pCategoryId, $supplierCategories);

            $view->suppliers = $suppliers;
            $activeSupplierId = $request->getParam('s', 0);
            $view->activeSupplierId = $activeSupplierId;

            $view->mainCategoreis = false;
            if(in_array($pCategoryName, $config['mainCategoriesLayoutCategories'])){
                $view->mainCategoreis = $this->getMainCategories($config['mainCategoriesLayoutCategories']);
                $view->activeMainCategoryId = $pCategoryId;
            }

            $view->mainCategoreis = $this->getMainCategories($config['mainCategoriesLayoutCategories']);
            $view->subCategories = $this->getSubCategories($pCategoryId, $activeSupplierId);
            $view->subofCategories = $this->getSubofCategories($pCategoryId,$activeSupplierId);
          

            $view->activeSubCategoryId = $request->getParam('sCategory', 0);
            $view->url = $this->getBaseUrl();

        }
    }

    private function getParentCategory($sCategory)
    {

        $sql = "select path from s_categories where id = {$sCategory};";
        $path = Shopware()->Db()->fetchOne($sql);

        $path = trim($path, '|');
        $pathElements = explode('|', $path);

        if(count($pathElements) > 1){
            $sCategory = $pathElements[0];
        }

        $sql = "select id, description as name from s_categories where id = {$sCategory};";
        return Shopware()->Db()->fetchRow($sql);

    }

    private function getSupplierCategories()
    {
        $sql = "SELECT supplierID, related_categories FROM s_articles_supplier_attributes WHERE related_categories IS NOT NULL AND related_categories != '';";
        return Shopware()->Db()->fetchAll($sql);
    }

    private function getMappedSupplierByParentCategory($categoryId, $supplierCategory)
    {

        $supplierId = $supplierCategory['supplierID'];
        $categoryIds = str_replace('|', ',', trim($supplierCategory['related_categories'], '|'));
        $supplier = false;

        $sql = "select id from s_categories where parent = {$categoryId} and id in ($categoryIds);";
        if(Shopware()->Db()->fetchOne($sql)){
            $supplier = $this->getSupplier($supplierId);
        }

        return $supplier;
    }

    private function getSupplier($supplierId)
    {
        $supplierObj = Shopware()->Models()->getRepository(Supplier::class)->find($supplierId);
        $supplier['id'] = $supplierObj->getId();
        $supplier['name'] = $supplierObj->getName();
        $supplier['image'] = $supplierObj->getImage();
        $supplier['link'] = $this->getSupplierFilterLink($supplierId);
        $supplier['description'] = $supplierObj->getDescription();
        return $supplier;
    }

    private function getSuppliers($pCategory, $supplierCategories)
    {

        foreach ($supplierCategories as $supplierCategory){
            $supplier = $this->getMappedSupplierByParentCategory($pCategory, $supplierCategory);
            if($supplier){
                $suppliers[] = $supplier;
            }
        }

        return $suppliers;
    }

    private function getSupplierFilterLink($supplierId)
    {
        $uri = $_SERVER['REQUEST_URI'];
        $qs = $_SERVER['QUERY_STRING'];
        $parameter = [];
        if($qs){
            $qsParameters = explode('&', $qs);
            foreach ($qsParameters as $qsParameter){
                list($key, $value) = explode('=', $qsParameter);
                $parameter[$key] = $value;
            }
        }
        $parameter['s'] = $supplierId;
        $url = parse_url($uri, PHP_URL_PATH);
        $queryString = '?' . http_build_query($parameter, '', '&');

        return $url . $queryString;
    }

    private function getMainCategories($categoriesName)
    {
        $categoriesNameIn = "'".implode("','", $categoriesName)."'";
        $sql = "select id, description as name from s_categories where description in ({$categoriesNameIn}) order by id;";
        $categories = Shopware()->Db()->fetchAll($sql);
        foreach ($categories as &$category){
            $category['link'] = $this->getCategoryLink($category['id']);
        }
        return $categories;
    }

    private function getCategoryLink($categoryId)
    {
        $shopConfig = Shopware()->Config();
        $baseFile = $shopConfig->baseFile;

        $qs = $_SERVER['QUERY_STRING'];
        $parameter = [];
        if($qs){
            $qsParameters = explode('&', $qs);
            foreach ($qsParameters as $qsParameter){
                list($key, $value) = explode('=', $qsParameter);
                $parameter[$key] = $value;
            }
        }
        $parameter['sViewport'] = 'cat';
        $parameter['sCategory'] = $categoryId;

        return $this->getBaseUrl() . $baseFile . '?'. http_build_query(
                $parameter,
                '',
                '&'
            );
    }

    private function getBaseUrl()
    {
        if ($this->container->has('Shop')) {
            /** @var Shop $shop */
            $shop = $this->container->get('Shop');
        } else {
            /** @var Shop $shop */
            $shop = $this->container->get('models')->getRepository(Shop::class)->getActiveDefault();
        }

        if ($shop->getMain()) {
            $shop = $shop->getMain();
        }

        $baseUrl =  'http://' . $shop->getHost() . $shop->getBasePath() . '/';
        if ($shop->getSecure()) {
            $baseUrl = 'https://' . $shop->getHost() . $shop->getBasePath() . '/';
        }

        return $baseUrl;
    }

    private function getSubCategories($pCategoryId, $supplierId)
    {
        $andSupplierCategories = '';
        if ($supplierId) {
            $supplierCategoreis = $this->getSupplierCategory($supplierId);

            $categoryIds = str_replace('|', ',', trim($supplierCategoreis, '|'));
            $andSupplierCategories = " and id in  ({$categoryIds}) ";
        }
        $sql = "select id, description as name from s_categories where parent = {$pCategoryId} {$andSupplierCategories} order by id;";
        $categories = Shopware()->Db()->fetchAll($sql);
        foreach ($categories as &$category) {
            $category['link'] = $this->getCategoryLink($category['id']);
            
        }
        return $categories;
    }

    private function getSubofCategories($pCategoryId, $supplierId)
    {
        $andSupplierCategories = '';
        if ($supplierId) {
            $supplierCategoreis = $this->getSupplierCategory($supplierId);

            $categoryIds = str_replace('|', ',', trim($supplierCategoreis, '|'));
            $andSupplierCategories = " and id in  ({$categoryIds}) ";
        }
        $sqlsubCategory = "select id, description as name from s_categories where parent = {$pCategoryId} {$andSupplierCategories} order by id;";
        $subcategories = Shopware()->Db()->fetchAll($sqlsubCategory);

        foreach ($subcategories as $subcategory) {
            $subCategoryId = $subcategory['id'];
            $sqlsubCategoryLayer1 = "select id, description as name
            from s_categories where parent = {$subCategoryId}    order by id;";

            $chkcategory = Shopware()->Db()->fetchAll($sqlsubCategoryLayer1);


        }
        return $chkcategory;
    }

    

    private function getSupplierCategory($supplierId)
    {
        $sql = "SELECT related_categories FROM s_articles_supplier_attributes WHERE supplierID = {$supplierId} and related_categories IS NOT NULL AND related_categories != '';";
        return Shopware()->Db()->fetchOne($sql);
    }


}
