<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\Tests\Functional\Subscriber\ControllerRegistration;

use SwagPaymentPayPalUnified\Subscriber\ControllerRegistration\Backend;

class BackendRegistrationSubscriberTest extends \PHPUnit_Framework_TestCase
{
    public function test_can_be_created()
    {
        $subscriber = new Backend(Shopware()->Container()->getParameter('paypal_unified.plugin_dir'), Shopware()->Container()->get('template'));
        static::assertNotNull($subscriber);
    }

    public function test_getSubscribedEvents()
    {
        $events = Backend::getSubscribedEvents();
        static::assertCount(6, $events);
        static::assertEquals('onGetBackendControllerPath', $events['Enlight_Controller_Dispatcher_ControllerPath_Backend_PaypalUnified']);
        static::assertEquals('onGetBackendSettingsControllerPath', $events['Enlight_Controller_Dispatcher_ControllerPath_Backend_PaypalUnifiedSettings']);
        static::assertEquals('onGetBackendGeneralSettingsControllerPath', $events['Enlight_Controller_Dispatcher_ControllerPath_Backend_PaypalUnifiedGeneralSettings']);
        static::assertEquals('onGetBackendExpressSettingsControllerPath', $events['Enlight_Controller_Dispatcher_ControllerPath_Backend_PaypalUnifiedExpressSettings']);
        static::assertEquals('onGetBackendInstallmentsSettingsControllerPath', $events['Enlight_Controller_Dispatcher_ControllerPath_Backend_PaypalUnifiedInstallmentsSettings']);
        static::assertEquals('onGetBackendPlusSettingsControllerPath', $events['Enlight_Controller_Dispatcher_ControllerPath_Backend_PaypalUnifiedPlusSettings']);
    }

    public function test_onGetBackendControllerPath()
    {
        $subscriber = new Backend(Shopware()->Container()->getParameter('paypal_unified.plugin_dir'), Shopware()->Container()->get('template'));
        $backendControllerPath = $subscriber->onGetBackendControllerPath();

        static::assertFileExists($backendControllerPath);

        /** @var \Enlight_Template_Manager $template */
        $template = Shopware()->Container()->get('template');
        $templateDirs = $template->getTemplateDir();

        //Do not use the absolute path, since it's different from machine to machine
        static::assertContains('/SwagPaymentPayPalUnified/Resources/views/', implode('', $templateDirs));
    }

    public function test_onGetSettingsControllerPath()
    {
        $subscriber = new Backend(Shopware()->Container()->getParameter('paypal_unified.plugin_dir'), Shopware()->Container()->get('template'));
        $backendControllerPath = $subscriber->onGetBackendSettingsControllerPath();

        static::assertFileExists($backendControllerPath);

        /** @var \Enlight_Template_Manager $template */
        $template = Shopware()->Container()->get('template');
        $templateDirs = $template->getTemplateDir();

        //Do not use the absolute path, since it's different from machine to machine
        static::assertContains('/SwagPaymentPayPalUnified/Resources/views/', implode('', $templateDirs));
    }

    public function test_onGetGeneralSettingsControllerPath()
    {
        $subscriber = new Backend(Shopware()->Container()->getParameter('paypal_unified.plugin_dir'), Shopware()->Container()->get('template'));
        $backendControllerPath = $subscriber->onGetBackendGeneralSettingsControllerPath();

        static::assertFileExists($backendControllerPath);
    }

    public function test_onGetExpressSettingsControllerPath()
    {
        $subscriber = new Backend(Shopware()->Container()->getParameter('paypal_unified.plugin_dir'), Shopware()->Container()->get('template'));
        $backendControllerPath = $subscriber->onGetBackendExpressSettingsControllerPath();

        static::assertFileExists($backendControllerPath);
    }

    public function test_onGetInstallmentsSettingsControllerPath()
    {
        $subscriber = new Backend(Shopware()->Container()->getParameter('paypal_unified.plugin_dir'), Shopware()->Container()->get('template'));
        $backendControllerPath = $subscriber->onGetBackendInstallmentsSettingsControllerPath();

        static::assertFileExists($backendControllerPath);
    }

    public function test_onGetPlusSettingsControllerPath()
    {
        $subscriber = new Backend(Shopware()->Container()->getParameter('paypal_unified.plugin_dir'), Shopware()->Container()->get('template'));
        $backendControllerPath = $subscriber->onGetBackendPlusSettingsControllerPath();

        static::assertFileExists($backendControllerPath);
    }
}
