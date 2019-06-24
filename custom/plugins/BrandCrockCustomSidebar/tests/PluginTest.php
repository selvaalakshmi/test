<?php

namespace BrandCrockCustomSidebar\Tests;

use BrandCrockCustomSidebar\BrandCrockCustomSidebar as Plugin;
use Shopware\Components\Test\Plugin\TestCase;

class PluginTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'BrandCrockCustomSidebar' => []
    ];

    public function testCanCreateInstance()
    {
        /** @var Plugin $plugin */
        $plugin = Shopware()->Container()->get('kernel')->getPlugins()['BrandCrockCustomSidebar'];

        $this->assertInstanceOf(Plugin::class, $plugin);
    }
}
