<?php
/**
 * overwrite the LegacyStructConverter
 * expand the convertListProductStruct-method
 */
namespace CompraSuggestionSearch\Compatibility;
use Shopware\Bundle\StoreFrontBundle;
use Shopware\Bundle\StoreFrontBundle\Struct\Product\Price;
use Shopware\Components\Compatibility;

/**
 * Class ExpandLegacyStructConverter
 * @package CompraPlugins\CompraSuggestionSearch\Compatibility
 */
class ExpandLegacyStructConverter extends Compatibility\LegacyStructConverter {

    /**
     * @var Compatibility\LegacyStructConverter
     */
    private $legacyStructConverter;

    /**
     * ExpandLegacyStructConverter constructor.
     * @param Compatibility\LegacyStructConverter $struct
     */
    public function __construct(Compatibility\LegacyStructConverter $struct)
    {
        $this->legacyStructConverter = $struct;
    }

    /**
     * @param StoreFrontBundle\Struct\Country[] $countries
     * @return array
     */
    public function convertCountryStructList($countries)
    {
        return $this->legacyStructConverter->convertCountryStructList($countries);
    }

    /**
     * @param StoreFrontBundle\Struct\Country $country
     * @return array
     */
    public function convertCountryStruct(StoreFrontBundle\Struct\Country $country)
    {
        return $this->legacyStructConverter->convertCountryStruct($country);
    }


    /**
     * @param StoreFrontBundle\Struct\Country\State[] $states
     * @return array
     */
    public function convertStateStructList($states)
    {
        return $this->legacyStructConverter->convertStateStructList($states);
    }

    /**
     * @param StoreFrontBundle\Struct\Country\State $state
     * @return array
     */
    public function convertStateStruct(StoreFrontBundle\Struct\Country\State $state)
    {
        return $this->legacyStructConverter->convertStateStruct($state);
    }

    /**
     * Converts a configurator group struct which used for default or selection configurators.
     *
     * @param StoreFrontBundle\Struct\Configurator\Group $group
     * @return array
     */
    public function convertConfiguratorGroupStruct(StoreFrontBundle\Struct\Configurator\Group $group)
    {
        return $this->legacyStructConverter->convertConfiguratorGroupStruct($group);
    }

    /**
     * @param StoreFrontBundle\Struct\Category $category
     * @return array
     * @throws \Exception
     */
    public function convertCategoryStruct(StoreFrontBundle\Struct\Category $category)
    {
        return $this->legacyStructConverter->convertCategoryStruct($category);
    }


    /**
     * @param StoreFrontBundle\Struct\ListProduct[] $products
     * @return array
     */
    public function convertListProductStructList(array $products)
    {
        return $this->legacyStructConverter->convertListProductStructList($products);
    }

    /**
     * Converts the passed ListProduct struct to a shopware 3-4 array structure.
     * Expand: expands the Listproduct for categories
     * @param StoreFrontBundle\Struct\ListProduct $product
     * @return array
     */
    public function convertListProductStruct(StoreFrontBundle\Struct\ListProduct $product)
    {
        $data = $this->legacyStructConverter->convertListProductStruct($product);
        if (method_exists($product, 'getCategories')) {
            $data['categories'] = $product->getCategories();
        } else {
            $data['categories'] = [];
        }
        return $data;
    }

    /**
     * Converts the passed ProductStream struct to an array structure.
     *
     * @param StoreFrontBundle\Struct\ProductStream $productStream
     * @return array
     */
    public function convertRelatedProductStreamStruct(StoreFrontBundle\Struct\ProductStream $productStream)
    {
        return $this->legacyStructConverter->convertRelatedProductStreamStruct($productStream);
    }
    /**
     * @param StoreFrontBundle\Struct\Product $product
     * @return array
     */
    public function convertProductStruct(StoreFrontBundle\Struct\Product $product)
    {
        return $this->legacyStructConverter->convertProductStruct($product);
    }

    /**
     * @param StoreFrontBundle\Struct\Product\VoteAverage $average
     * @return array
     */
    public function convertVoteAverageStruct(StoreFrontBundle\Struct\Product\VoteAverage $average)
    {
        return $this->legacyStructConverter->convertVoteAverageStruct($average);
    }

    /**
     * @param StoreFrontBundle\Struct\Product\Vote $vote
     * @return array
     */
    public function convertVoteStruct(StoreFrontBundle\Struct\Product\Vote $vote)
    {
        return $this->legacyStructConverter->convertVoteStruct($vote);
    }


    /**
     * @param StoreFrontBundle\Struct\Product\Price $price
     * @return array
     */
    public function convertPriceStruct(StoreFrontBundle\Struct\Product\Price $price)
    {
        return $this->legacyStructConverter->convertPriceStruct($price);
    }
    /**
     * @param StoreFrontBundle\Struct\Media $media
     * @return array
     */
    public function convertMediaStruct(StoreFrontBundle\Struct\Media $media = null)
    {
        return $this->legacyStructConverter->convertMediaStruct($media);
    }

    /**
     * @param StoreFrontBundle\Struct\Product\Unit $unit
     * @return array
     */
    public function convertUnitStruct(StoreFrontBundle\Struct\Product\Unit $unit)
    {
        return $this->legacyStructConverter->convertUnitStruct($unit);
    }

    /**
     * @param StoreFrontBundle\Struct\Product\Manufacturer $manufacturer
     * @return string
     */
    public function getSupplierListingLink(StoreFrontBundle\Struct\Product\Manufacturer $manufacturer)
    {
        return $this->legacyStructConverter->getSupplierListingLink($manufacturer);
    }
    /**
     * @param StoreFrontBundle\Struct\Property\Set $set
     * @return array
     */
    public function convertPropertySetStruct(StoreFrontBundle\Struct\Property\Set $set)
    {
        return $this->legacyStructConverter->convertPropertySetStruct($set);
    }

    /**
     * @param StoreFrontBundle\Struct\Property\Group $group
     * @return array
     */
    public function convertPropertyGroupStruct(StoreFrontBundle\Struct\Property\Group $group)
    {
        return $this->legacyStructConverter->convertPropertyGroupStruct($group);
    }

    /**
     * @param StoreFrontBundle\Struct\Property\Option $option
     * @return array
     */
    public function convertPropertyOptionStruct(StoreFrontBundle\Struct\Property\Option $option)
    {
        return $this->legacyStructConverter->convertPropertyOptionStruct($option);
    }

    /**
     * @param StoreFrontBundle\Struct\Product\Manufacturer $manufacturer
     * @return array
     */
    public function convertManufacturerStruct(StoreFrontBundle\Struct\Product\Manufacturer $manufacturer)
    {
        return $this->legacyStructConverter->convertManufacturerStruct($manufacturer);
    }

    /**
     * @param StoreFrontBundle\Struct\ListProduct $product
     * @param StoreFrontBundle\Struct\Configurator\Set $set
     * @return array
     */
    public function convertConfiguratorStruct(
        StoreFrontBundle\Struct\ListProduct $product,
        StoreFrontBundle\Struct\Configurator\Set $set
    ) {
        return $this->legacyStructConverter->convertConfiguratorStruct($product, $set);
    }

    /**
     * @param StoreFrontBundle\Struct\Blog\Blog $blog
     * @return array
     */
    public function convertBlogStruct(StoreFrontBundle\Struct\Blog\Blog $blog)
    {
        return $this->legacyStructConverter->convertBlogStruct($blog);
    }

    /**
     * @param StoreFrontBundle\Struct\Payment $payment
     * @return array
     */
    public function convertPaymentStruct(StoreFrontBundle\Struct\Payment $payment)
    {
        return $this->legacyStructConverter->convertPaymentStruct($payment);
    }

    /**
     * @param Price $price
     * @return array
     */
    public function convertProductPriceStruct(Price $price)
    {
        return $this->legacyStructConverter->convertProductPriceStruct($price);
    }


    /**
     * @param StoreFrontBundle\Struct\ListProduct $product
     * @param StoreFrontBundle\Struct\Configurator\Set $set
     * @return array
     */
    public function convertConfiguratorPrice(
        StoreFrontBundle\Struct\ListProduct $product,
        StoreFrontBundle\Struct\Configurator\Set $set
    ) {
        return $this->legacyStructConverter->convertConfiguratorPrice($product, $set);
    }

    /**
     * Creates the settings array for the passed configurator set
     *
     * @param StoreFrontBundle\Struct\Configurator\Set $set
     * @param StoreFrontBundle\Struct\ListProduct $product
     * @return array
     */
    public function getConfiguratorSettings(
        StoreFrontBundle\Struct\Configurator\Set $set,
        StoreFrontBundle\Struct\ListProduct $product
    ) {
        return $this->legacyStructConverter->getConfiguratorSettings($set, $product);
    }

    /**
     * Converts a configurator option struct which used for default or selection configurators.
     *
     * @param StoreFrontBundle\Struct\Configurator\Group $group
     * @param StoreFrontBundle\Struct\Configurator\Option $option
     * @return array
     */
    public function convertConfiguratorOptionStruct(
        StoreFrontBundle\Struct\Configurator\Group $group,
        StoreFrontBundle\Struct\Configurator\Option $option
    ) {
        return $this->legacyStructConverter->convertConfiguratorOptionStruct($group, $option);
    }
}