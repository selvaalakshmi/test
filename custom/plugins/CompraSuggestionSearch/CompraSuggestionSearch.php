<?php

namespace CompraSuggestionSearch;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CompraSuggestionSearch extends Plugin
{
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('compra_suggestion_search.plugin_dir', $this->getPath());
        parent::build($container);
    }

    public function activate(ActivateContext $context)
    {
        parent::activate($context);

        $context->scheduleClearCache(ActivateContext::CACHE_LIST_ALL);
    }

    public function deactivate(DeactivateContext $context)
    {
        parent::deactivate($context);

        $context->scheduleClearCache(DeactivateContext::CACHE_LIST_ALL);
    }
}