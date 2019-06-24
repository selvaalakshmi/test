<?php
/**
 * Created by PhpStorm.
 * User: Khalid
 * Date: 17/04/2019
 * Time: 12:59 PM
 */
use Shopware\Models\Article\Supplier;
class Shopware_Controllers_Widgets_CustomAdvanceMenu extends Enlight_Controller_Action
{
    public function getSupplierCategoryAction()
    {
        $this->View()->addTemplateDir(dirname(dirname(dirname(__FILE__))).'/Resources/views');

        $parentCategoryId = $this->Request()->getParam('parentCategoryId');
        $supplierId = $this->Request()->getParam('supplierId');

//        var_dump($parentCategoryId, $supplierId); die();
//        var_dump(dirname(dirname(dirname(__FILE__))).'/Resources/views');die();

        $supplier = $this->getSupplier($supplierId);
        $category = $this->getCategoryById($parentCategoryId);


        $supplierCategoryIds = $this->getSupplierCategoryIds($supplierId);

        $tmp = [];
        foreach ($supplierCategoryIds as $supplierCategoryId){
            $tmp[] = $category['children'][$supplierCategoryId];
        }

        $filteredCategories = array_filter($tmp);


        $this->View()->assign('supplier', $supplier);
        $this->View()->assign('parentCategoryId', $parentCategoryId);
        $this->View()->assign('categories', $filteredCategories);
    }


    private function getSupplier($supplierId)
    {
        $supplierObj = Shopware()->Models()->getRepository(Supplier::class)->find($supplierId);
        $supplier['id'] = $supplierObj->getId();
        $supplier['name'] = $supplierObj->getName();
        $supplier['image'] = $supplierObj->getImage();
        $supplier['link'] = $supplierObj->getLink();
        $supplier['description'] = $supplierObj->getDescription();
        return $supplier;
    }

    private function getCategoryById($categoryId)
    {
        $childrenIds = $this->getCategoryChildrenIds($categoryId);
        $childrenIds[] = $categoryId;

        $context = $this->container->get('shopware_storefront.context_service')->getShopContext();
        $categories = $this->container->get('shopware_storefront.category_service')->getList($childrenIds, $context);

        $converted = [];
        foreach ($categories as $category) {
            $temp = $this->container->get('legacy_struct_converter')->convertCategoryStruct($category);
            $childrenIds = $this->getCategoryChildrenIds($category->getId());
            $temp['childrenCount'] = count($childrenIds);
            $converted[$category->getId()] = $temp;
        }

        $result = $converted[$categoryId];
        unset($converted[$categoryId]);
        $result['children'] = $converted;
        $result['childrenCount'] = count($converted);

        return $result;
    }

    private function getCategoryChildrenIds($categoryId)
    {
        $query = $this->container->get('dbal_connection')->createQueryBuilder();
        $query->select('category.id')
            ->from('s_categories', 'category')
            ->where('category.parent = :parentId')
            ->andWhere('category.active = 1')
            ->setParameter(':parentId', $categoryId);

        return $query->execute()->fetchAll(PDO::FETCH_COLUMN);
    }

    private function getSupplierCategoryIds($supplierId)
    {
        $sql = "SELECT related_categories FROM s_articles_supplier_attributes WHERE supplierID = {$supplierId};";
        $relatedCategories = Shopware()->Db()->fetchOne($sql);
        $relatedCategories = trim($relatedCategories, '|');
        return explode('|', $relatedCategories);
    }
}
