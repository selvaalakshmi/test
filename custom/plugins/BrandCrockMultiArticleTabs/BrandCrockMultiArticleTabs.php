<?php

namespace BrandCrockMultiArticleTabs;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\ORM\Tools\SchemaTool;
class BrandCrockMultiArticleTabs extends Plugin
{

    public function install(InstallContext $installContext)
    {
       // parent::install($installContext);
        $this->createSchema();
        $this->createAttributes();
        $docPath = Shopware()->DocPath();
        $destinationDir = $docPath. 'files/PDF-File';
        if (!file_exists($destinationDir)) {
            mkdir($destinationDir, 0777, true);
        }
    }

    public function uninstall(UninstallContext $uninstallContext)
    {
        $this->removeSchema();
        $this->removeAttributes();
        $basePath = Shopware()->DocPath();
        $directoryPath = $basePath . 'files/PDF-File';
        $files = glob($basePath . 'files/PDF-File/*');
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
        if(!empty($directoryPath)){
            rmdir($directoryPath);

        }
        $uninstallContext->scheduleClearCache(UninstallContext::CACHE_LIST_ALL);

        //return  parent::uninstall($uninstallContext);
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
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('brand_crock_multi_article_tabs.plugin_name', 'BrandCrockMultiArticleTabs');
        $container->setParameter('brand_crock_multi_article_tabs.plugin_dir', $this->getPath());
        parent::build($container);
    }

    /**
     * creates database tables on base of doctrine models
     */
    private function createSchema()
    {
        $tool = new SchemaTool($this->container->get('models'));
        $classes = [
            $this->container->get('models')->getClassMetadata(\BrandCrockMultiArticleTabs\Models\BcghPdfDetails::class),
            $this->container->get('models')->getClassMetadata(\BrandCrockMultiArticleTabs\Models\BcghFaqDetails::class)

        ];
        $tool->createSchema($classes);
    }

    private function removeSchema()
    {
        $tool = new SchemaTool($this->container->get('models'));
        $classes = [
            $this->container->get('models')->getClassMetadata(\BrandCrockMultiArticleTabs\Models\BcghPdfDetails::class),
            $this->container->get('models')->getClassMetadata(\BrandCrockMultiArticleTabs\Models\BcghFaqDetails::class)

        ];
        $tool->dropSchema($classes);
    }

    private function createAttributes(){
       
        $service1 = $this->container->get('shopware_attribute.crud_service');

      

        $service1->update('s_articles_attributes', 'bcgh_product_info', 'html', [
            'label' => 'Product Information',
            'translatable' => true,
            'displayInBackend' => true,
            'position' => 32,
        ]);

        // Sometimes it's necessary to rebuild the attribute models after attribute creation, update or deletion.
        $metaDataCache = Shopware()->Models()->getConfiguration()->getMetadataCacheImpl();
        $metaDataCache->deleteAll();
        Shopware()->Models()->generateAttributeModels(['s_articles_attributes']);
    }

    private function removeAttributes(){

        

        $service1 = $this->container->get('shopware_attribute.crud_service');
        $service1->delete('s_articles_attributes', 'bcgh_product_info');


        // Sometimes it's necessary to rebuild the attribute models after attribute creation, update or deletion.
        $metaDataCache = Shopware()->Models()->getConfiguration()->getMetadataCacheImpl();
        $metaDataCache->deleteAll();
        Shopware()->Models()->generateAttributeModels(['s_articles_attributes']);

    }

	 

   
}