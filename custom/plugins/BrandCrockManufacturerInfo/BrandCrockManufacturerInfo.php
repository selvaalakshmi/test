<?php
namespace BrandCrockManufacturerInfo;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\ORM\Tools\SchemaTool;
class BrandCrockManufacturerInfo extends Plugin
{

    public function install(InstallContext $installContext)
    {
        $this->createSchema();
        $midocPath = Shopware()->DocPath();
        $midestinationDir = $midocPath. 'files/Manufacturer-Img';
        if (!file_exists($midestinationDir)) {
            mkdir($midestinationDir, 0777, true);
        }
    }

    public function uninstall(UninstallContext $uninstallContext)
    {
        $this->removeSchema();

        $mibasePath = Shopware()->DocPath();
        $midirectoryPath = $mibasePath . 'files/Manufacturer-Img';
        $mifiles = glob($mibasePath . 'files/Manufacturer-Img/*');
        foreach($mifiles as $mifile){ // iterate files
            if(is_file($mifile))
                unlink($mifile); // delete file
        }
        if(!empty($midirectoryPath)){
            rmdir($midirectoryPath);

        }
        $uninstallContext->scheduleClearCache(UninstallContext::CACHE_LIST_ALL);
    }
    public function activate(ActivateContext $activateContext)
    {
        $activateContext->scheduleClearCache(ActivateContext::CACHE_LIST_ALL);
    }

    public function deactivate(DeactivateContext $deactivateContext)
    {
        $deactivateContext->scheduleClearCache(DeactivateContext::CACHE_LIST_ALL);
    }
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('brand_crock_manufacturer_info.plugin_name', 'BrandCrockManufacturerInfo');
        $container->setParameter('brand_crock_manufacturer_info.plugin_dir', $this->getPath());
        parent::build($container);
    }

    /**
     * creates database tables on base of doctrine models
     */
    private function createSchema()
    {
        $tool = new SchemaTool($this->container->get('models'));
        $classes = [
            $this->container->get('models')->getClassMetadata(\BrandCrockManufacturerInfo\Models\BcghManufacturer::class)
        ];
        $tool->createSchema($classes);
    }
    private function removeSchema()
    {
        $tool = new SchemaTool($this->container->get('models'));
        $classes = [
            $this->container->get('models')->getClassMetadata(\BrandCrockManufacturerInfo\Models\BcghManufacturer::class)
        ];
        $tool->dropSchema($classes);
    }

}