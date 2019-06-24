<?php
class Shopware_Proxies_ShopwareControllersWidgetsIndexProxy extends \Shopware_Controllers_Widgets_Index implements \Enlight_Hook_Proxy
{

    private $__hookProxyExecutionContexts = null;

    /**
     * @inheritdoc
     */
    public static function getHookMethods()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function __pushHookExecutionContext($method, Enlight_Hook_HookExecutionContext $context)
    {
        $this->__hookProxyExecutionContexts[$method][] = $context;
    }

    /**
     * @inheritdoc
     */
    public function __popHookExecutionContext($method)
    {
        if (isset($this->__hookProxyExecutionContexts[$method])) {
            array_pop($this->__hookProxyExecutionContexts[$method]);
        }
    }

    /**
     * @inheritdoc
     */
    public function __getCurrentHookProxyExecutionContext($method)
    {
        if (!isset($this->__hookProxyExecutionContexts[$method]) || count($this->__hookProxyExecutionContexts[$method]) === 0) {
            return null;
        }

        $contextCount = count($this->__hookProxyExecutionContexts[$method]);
        $context = $this->__hookProxyExecutionContexts[$method][$contextCount - 1];

        return $context;
    }

    /**
     * @inheritdoc
     */
    public function __getActiveHookManager($method)
    {
        $context = $this->__getCurrentHookProxyExecutionContext($method);
        $hookManager = ($context) ? $context->getHookManager() : Shopware()->Hooks();

        return $hookManager;
    }

    /**
     * @inheritdoc
     */
    public function executeParent($method, array $args = array())
    {
        $context = $this->__getCurrentHookProxyExecutionContext($method);
        if (!$context) {
            throw new Exception(
                sprintf('Cannot execute parent without hook execution context for method "%s"', $method)
            );
        }

        return $context->executeReplaceChain($args);
    }

    /**
     * @inheritdoc
     */
    public function __executeOriginalMethod($method, array $args = array())
    {
        return parent::{$method}(...$args);
    }


}
