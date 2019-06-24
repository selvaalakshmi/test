<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\Tests\Functional\WebhookHandler;

use SwagPaymentPayPalUnified\Components\PaymentStatus;
use SwagPaymentPayPalUnified\PayPalBundle\Components\Webhook\WebhookEventTypes;
use SwagPaymentPayPalUnified\PayPalBundle\Structs\Webhook;
use SwagPaymentPayPalUnified\Tests\Functional\DatabaseTestCaseTrait;
use SwagPaymentPayPalUnified\WebhookHandlers\AuthorizationVoided;

class AuthorizationVoidedTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseTestCaseTrait;

    const TEST_ORDER_ID = 15;

    /**
     * @before
     */
    public function setOrderTransacactionId()
    {
        $sql = "UPDATE s_order SET temporaryID = 'TEST_ID' WHERE id=" . self::TEST_ORDER_ID;

        Shopware()->Db()->executeUpdate($sql);
    }

    public function test_can_construct()
    {
        $instance = new AuthorizationVoided(Shopware()->Container()->get('paypal_unified.logger_service'), Shopware()->Container()->get('models'));

        static::assertInstanceOf(AuthorizationVoided::class, $instance);
    }

    public function test_invoke_returns_true_because_the_order_status_has_been_updated()
    {
        $instance = new AuthorizationVoided(Shopware()->Container()->get('paypal_unified.logger_service'), Shopware()->Container()->get('models'));

        static::assertTrue($instance->invoke($this->getWebhookStruct()));

        $sql = 'SELECT cleared FROM s_order WHERE id=' . self::TEST_ORDER_ID;

        $status = Shopware()->Db()->fetchOne($sql);
        static::assertEquals(PaymentStatus::PAYMENT_STATUS_CANCELLED, $status);
    }

    public function test_invoke_returns_false_because_the_order_does_not_exist()
    {
        $instance = new AuthorizationVoided(Shopware()->Container()->get('paypal_unified.logger_service'), Shopware()->Container()->get('models'));

        static::assertFalse($instance->invoke($this->getWebhookStruct('ORDER_NOT_AVAILABLE')));
    }

    public function test_getEventType_is_correct()
    {
        $instance = new AuthorizationVoided(Shopware()->Container()->get('paypal_unified.logger_service'), Shopware()->Container()->get('models'));
        static::assertEquals(WebhookEventTypes::PAYMENT_AUTHORIZATION_VOIDED, $instance->getEventType());
    }

    public function test_invoke_will_return_false_without_active_entity_manager()
    {
        $instance = new AuthorizationVoided(Shopware()->Container()->get('paypal_unified.logger_service'), new EntityManagerMock());

        static::assertFalse($instance->invoke($this->getWebhookStruct(self::TEST_ORDER_ID)));
    }

    /**
     * @param string $id
     *
     * @return Webhook
     */
    private function getWebhookStruct($id = 'TEST_ID')
    {
        return Webhook::fromArray([
            'event_type' => WebhookEventTypes::PAYMENT_AUTHORIZATION_VOIDED,
            'id' => 1,
            'create_time' => '',
            'resource' => [
                'parent_payment' => $id,
            ],
        ]);
    }
}
