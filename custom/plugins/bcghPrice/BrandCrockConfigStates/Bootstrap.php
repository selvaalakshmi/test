<?php

class Shopware_Plugins_Backend_BrandCrockConfigStates_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
    private $pluginName = 'FriedmConfigStates';
    private $pluginDir = 'friedm_config_states';
    protected $manager = null;

    /**
     * install plugin method
     *
     * @return bool
     */
    public function install()
    {
        $this->subscribeEvent(
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_' . $this->pluginName,
            'onGetControllerPathBackend'
        );
        $this->subscribeEvent(
            'Enlight_Controller_Action_PostDispatch_Backend_Base',
            'onPostDispatchBackendBase',
            110
        );
        $this->subscribeEvent(
            'Enlight_Controller_Action_PostDispatch_Backend_Config',
            'onPostDispatchBackendConfig',
            110
        );
        $this->subscribeEvent(
            'Shopware\Models\Order\Repository::getOrderStatusQueryBuilder::after',
            'getOrderStatusQueryBuilder'
        );
        $this->createForm();
        $this->mkJsFile();

        return true;
    }

    /**
     * getInfo plugin method
     *
     * @return array
     */
    public function getInfo()
    {
        return [
            'label' => $this->getLabel(),
            'version' => $this->getVersion(),
            'autor' => 'brandcrock GmbH',
        ];
    }

    /**
     * getLabel plugin method
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Brandcrock Zahlungsstatus';
    }

    /**
     * getVersion plugin method
     *
     * @return string
     */
    public function getVersion()
    {
        return '1.1.0';
    }

    /**
     * createForm plugin method
     *
     * @return void
     */
    public function createForm()
    {
        $form = $this->Form();
        $parent = $this->Forms()->findOneBy(['name' => 'Base']);
        $form->setParent($parent);
        $form->setPluginId(null);
    }

    /**
     * Shopware_Controllers_Backend plugin method
     *
     * @return string
     */
    public function onGetControllerPathBackend(Enlight_Event_EventArgs $args)
    {
        return $this->Path() . 'Controllers/Backend/' . $this->pluginName . '.php';
    }

    /**
     * base PostDispatch plugin method
     *
     * @return void
     */
    public function onPostDispatchBackendBase(Enlight_Event_EventArgs $args)
    {
        /** @var \Enlight_Controller_Action $controller */
        $controller = $args->getSubject();
        /** @var \Enlight_Controller_Request_RequestHttp $request */
        $request = $controller->Request();
        /** @var \Enlight_View_Default $view */
        $view = $controller->View();
        $view->addTemplateDir(dirname(__FILE__) . '/Views/');

        if ($request->getActionName() == 'index') {
            $view->extendsTemplate('backend/base/model/' . $this->pluginDir . '/order_status.js');
            $view->extendsTemplate('backend/base/model/' . $this->pluginDir . '/payment_status.js');
        }
    }

    /**
     * config PostDispatch plugin method
     *
     * @return void
     */
    public function onPostDispatchBackendConfig(Enlight_Event_EventArgs $args)
    {
        $request = $args->getSubject()->Request();
        $view = $args->getSubject()->View();
        $view->addTemplateDir(dirname(__FILE__) . '/Views/');

        if ($request->getActionName() == 'load') {
            $view->extendsTemplate('backend/config/model/form/' . $this->pluginDir . '.js');
            $view->extendsTemplate('backend/config/store/detail/' . $this->pluginDir . '.js');
            $view->extendsTemplate('backend/config/view/form/' . $this->pluginDir . '.js');
            $view->extendsTemplate('backend/config/view/' . $this->pluginDir . '/detail.js');
            $view->extendsTemplate('backend/config/controller/' . $this->pluginDir . '/form.js');
        }
    }

    /**
     * Shopware_Controllers_Backend_FriedmConfigStates::mkJsFile()
     *
     * @return void
     */
    public function mkJsFile()
    {
        $builder = $this->getManager()->createQueryBuilder();
        $builder->select(['status'])
            ->from('Shopware\Models\Order\Status', 'status');

        $data = $builder->getQuery()->getArrayResult();
        $snippets = [
            'state' => '',
            'payment' => ''
        ];
        foreach ($data as $key => $value) {
            $snippets[$value['group']] .= '"' . $value['name'] . '": "{s name=' . $value['name'] . '}' . $value['description'] . '{/s}",' . "\r\n";
        }

        $str = '//{namespace name=backend/static/order_status}
//{block name="backend/base/model/order_status" append}
Ext.define("Shopware.apps.Base.model.OrderStatus", {
	extend: "Shopware.apps.Base.model.OrderStatus",
    snippets: {
' . $snippets['state'] . '
    },
});
//{/block}';
        file_put_contents(dirname(__FILE__) . '/Views/backend/base/model/' . $this->pluginDir . '/order_status.js', $str);

        $str = '//{namespace name=backend/static/payment_status}
//{block name="backend/base/model/payment_status" append}
Ext.define("Shopware.apps.Base.model.PaymentStatus", {
	extend: "Shopware.apps.Base.model.PaymentStatus",
    snippets: {
' . $snippets['payment'] . '
    },
});
//{/block}';
        file_put_contents(dirname(__FILE__) . '/Views/backend/base/model/' . $this->pluginDir . '/payment_status.js', $str);

    }

    /**
     * hook to modify builder
     *
     * @param mixed $args
     *
     * @return void
     */
    public function getOrderStatusQueryBuilder(Enlight_Hook_HookArgs $args)
    {
        $builder = $args->getReturn();
        $builder->orderBy('status.position', 'ASC');
        $args->setReturn($builder);
    }

    /**
     * Internal helper function to get access to the entity manager.
     *
     * @return Shopware\Components\Model\ModelManager
     * @throws RuntimeException
     */
    public function getManager()
    {
        if ($this->manager === null) {
            $this->manager = Shopware()->Models();
        }

        return $this->manager;
    }
}
