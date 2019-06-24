<?php

namespace Shopware\Themes\Pfiff;

use Shopware\Components\Form as Form;

class Theme extends \Shopware\Components\Theme
{
    protected $extend = 'Responsive';

    protected $name = <<<'SHOPWARE_EOD'
pfiff
SHOPWARE_EOD;

    protected $description = <<<'SHOPWARE_EOD'
pfiff
SHOPWARE_EOD;

    protected $author = <<<'SHOPWARE_EOD'
zaheer
SHOPWARE_EOD;

    protected $license = <<<'SHOPWARE_EOD'

SHOPWARE_EOD;
    protected $css = [

        'src/css/owl.carousel.min.css',
        'src/css/owl.theme.default.min.css',
        'src/css/listing.css',
        'src/css/detail.css',
        'src/css/style.css',
        'src/css/all.css'


    ];

    protected $javascript = [
        'src/js/custom.js',
        'src/js/owl.carousel.min.js'
    ];

    public function createConfig(Form\Container\TabContainer $container)
    {
    }
}