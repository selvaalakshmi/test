<?php

namespace BrandCrockCustomAdvanceMenu;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Shopware\Models\Article\Supplier;

/**
 * Shopware-Plugin BrandCrockCustomAdvanceMenu.
 */
class BrandCrockCustomAdvanceMenu extends Plugin
{

    public function install(InstallContext $context)
    {
        $service = $this->container->get('shopware_attribute.crud_service');

        $service->update('s_articles_supplier_attributes', 'related_categories', 'multi_selection', [
            'label' => 'Categories',
            'displayInBackend' => true,
            'entity' => 'Shopware\Models\Category\Category',
        ]);

        $metaDataCache = Shopware()->Models()->getConfiguration()->getMetadataCacheImpl();
        $metaDataCache->deleteAll();
        Shopware()->Models()->generateAttributeModels(['s_articles_supplier_attributes']);
    }

    public function uninstall(UninstallContext $context)
    {
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->delete('s_articles_supplier_attributes', 'related_categories');

        $metaDataCache = Shopware()->Models()->getConfiguration()->getMetadataCacheImpl();
        $metaDataCache->deleteAll();
        Shopware()->Models()->generateAttributeModels(['s_articles_supplier_attributes']);
    }

    /**
    * @param ContainerBuilder $container
    */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('brand_crock_custom_advance_menu.plugin_name', $this->getName());
        $container->setParameter('brand_crock_custom_advance_menu.plugin_dir', $this->getPath());
        parent::build($container);
    }

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onPostDispatch'
        ];
    }



    /**
     * @param Enlight_Controller_ActionEventArgs $args
     */
    public function onPostDispatch(\Enlight_Event_EventArgs $args)
    {

        $config = $this->container->get('shopware.plugin.cached_config_reader')->getByPluginName($this->getName());
        if (!$config['show']) {
            return;
        }

        $view = $args->getSubject()->View();
        $view->addTemplateDir($this->getPath() . '/Resources/views');


        $parent = Shopware()->Shop()->get('parentID');
        $categoryId = $args->getRequest()->getParam('sCategory', $parent);
        $menu = $this->getAdvancedMenu($parent, $categoryId, 2);

        $view->assign('sAdvancedMenu', $menu);
//        $view->assign('columnAmount', $config['columnAmount']);
        $view->assign('hoverDelay', $config['hoverDelay']);
        $view->assign('flatLayoutCategories', $config['flatLayoutCategories']);
        $view->assign('tabLayoutCategories', $config['tabLayoutCategories']);

    }


    /**
     * Returns the complete menu with category path.
     *
     * @param int $category
     * @param int $activeCategoryId
     * @param int $depth
     *
     * @return array
     */
    public function getAdvancedMenu($category, $activeCategoryId, $depth = 2)
    {
        $context = Shopware()->Container()->get('shopware_storefront.context_service')->getShopContext();
        $cacheKey = 'Shopware_AdvancedMenu_Tree_' . $context->getShop()->getId() . '_' . $category . '_' . $context->getCurrentCustomerGroup()->getId();
        $cache = Shopware()->Container()->get('cache');

        $config = $this->container->get('shopware.plugin.cached_config_reader')->getByPluginName($this->getName());

        if ($config['caching'] && $cache->test($cacheKey)) {
            $menu = $cache->load($cacheKey, true);
        } else {
            $ids = $this->getCategoryIdsOfDepth($category, $depth);
            $categories = Shopware()->Container()->get('shopware_storefront.category_service')->getList($ids, $context);
            $categoriesArray = $this->convertCategories($categories);
            $categoryTree = $this->getCategoriesOfParent($category, $categoriesArray);
            $categoryTree = $this->mapSupplier($categoryTree);

            if ($config['caching']) {
                $cache->save($categoryTree, $cacheKey, ['Shopware_Plugin'], (int) $config['cachetime']);
            }
            $menu = $categoryTree;
        }

        $categoryPath = $this->getCategoryPath($activeCategoryId);
        $menu = $this->setActiveFlags($menu, $categoryPath);

        return $menu;
    }

    /**
     * @param int $parentId
     * @param int $depth
     *
     * @throws Exception
     *
     * @return int[]
     */
    private function getCategoryIdsOfDepth($parentId, $depth)
    {
        $query = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();
        $query->select('DISTINCT category.id')
            ->from('s_categories', 'category')
            ->where('category.path LIKE :path')
            ->andWhere('category.active = 1')
            ->andWhere('ROUND(LENGTH(path) - LENGTH(REPLACE (path, "|", "")) - 1) <= :depth')
            ->orderBy('category.position')
            ->setParameter(':depth', $depth)
            ->setParameter(':path', '%|' . $parentId . '|%');

        /** @var PDOStatement $statement */
        $statement = $query->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * @param Category[] $categories
     *
     * @return array
     */
    private function convertCategories($categories)
    {
        $converter = Shopware()->Container()->get('legacy_struct_converter');

        return array_map(function ($category) use ($converter) {
            $data = $converter->convertCategoryStruct($category);

            $data['flag'] = false;
            if ($category->getMedia()) {
                $data['media']['path'] = $category->getMedia()->getFile();
            }
            if (!empty($category->getExternalLink())) {
                $data['link'] = $category->getExternalLink();
            }

            return $data;
        }, $categories);
    }

    /**
     * @param int   $parentId
     * @param array $categories
     *
     * @return array
     */
    private function getCategoriesOfParent($parentId, $categories)
    {
        $result = [];

        foreach ($categories as $index => $category) {
            if ($category['parentId'] != $parentId) {
                continue;
            }
            $children = $this->getCategoriesOfParent($category['id'], $categories);
            $category['sub'] = $children;
            $category['activeCategories'] = count($children);
            $result[] = $category;
        }

        return $result;
    }

    /**
     * @param int $categoryId
     *
     * @throws Exception
     *
     * @return int[]
     */
    private function getCategoryPath($categoryId)
    {
        $query = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();

        $query->select('category.path')
            ->from('s_categories', 'category')
            ->where('category.id = :id')
            ->setParameter(':id', $categoryId);

        $path = $query->execute()->fetch(\PDO::FETCH_COLUMN);
        $path = explode('|', $path);
        $path = array_filter($path);
        $path[] = $categoryId;

        return $path;
    }

    /**
     * @param array[] $categories
     * @param int[]   $actives
     *
     * @return array[]
     */
    private function setActiveFlags($categories, $actives)
    {
        foreach ($categories as &$category) {
            $category['flag'] = in_array($category['id'], $actives);

            if (!empty($category['sub'])) {
                $category['sub'] = $this->setActiveFlags($category['sub'], $actives);
            }
        }

        return $categories;
    }

    private function mapSupplier(array $categoryTree)
    {

        $sql = "SELECT supplierID, related_categories FROM s_articles_supplier_attributes WHERE related_categories IS NOT NULL AND related_categories != '';";
        $supplierCategories = Shopware()->Db()->fetchAll($sql);

        $result = [];
        foreach ($categoryTree as $index => $category){
            $result[$index] = $category;
            unset($result[$index]['sub'], $result[$index]['attribute'], $result[$index]['attributes']); // remove unwanted elements
            if($category['sub']){
                $cats = [];
                foreach ($category['sub'] as $subCategory){
                    $mappedSupplier = $this->getMappedSupplier($subCategory['id'], $supplierCategories);
                    if($mappedSupplier){
                        $result[$index]['suppliers'][$mappedSupplier['id']] = $mappedSupplier;
                        $cats[$mappedSupplier['id']][$subCategory['id']] =  $subCategory;
                        $cats[$mappedSupplier['id']][$subCategory['id']]['articles'] =  $this->getTopArticles($subCategory['id'],5);
                        $result[$index]['suppliers'][$mappedSupplier['id']]['categories'] = $cats[$mappedSupplier['id']];
                    }
                }

            }
        }

        return $result;
    }

    private function getMappedSupplier($categoryId, $supplierCategories)
    {
        $supplier = false;
        foreach ($supplierCategories as $supplierCategory){
            if(preg_match("/\|{$categoryId}\|/", $supplierCategory['related_categories'])){
                $supplier = $this->getSupplier($supplierCategory['supplierID']);
                break;
            }
        }
        return $supplier;
    }

    private function getSupplier($supplierId)
    {
        $supplierObj = Shopware()->Models()->getRepository(Supplier::class)->find($supplierId);
        $supplier['id'] = $supplierObj->getId();
        $supplier['name'] = $supplierObj->getName();
        $supplier['image'] = $supplierObj->getImage();
        $supplier['link'] = $supplierObj->getLink();
        $supplier['description'] = $supplierObj->getDescription();
//        $supplier['attribute'] = $supplierObj->getAttribute();
        return $supplier;
    }

    private function getTopArticles($categoryId, $limit = 5)
    {

        $sql = "SELECT a.id, a.name
                FROM s_articles a
                INNER JOIN s_articles_categories_ro ac ON (a.id = ac.articleID)
                WHERE ac.categoryID = {$categoryId}
                LIMIT {$limit};";
        $result = Shopware()->Db()->fetchAll($sql);
        foreach ($result as $article){
            $articles[] = [
                'name' => $article['name'],
                'link' => Shopware()->Config()->get('baseFile') . "?sViewport=detail&sArticle=" . $article['id']
            ];
        }

        return $articles;
    }

}
