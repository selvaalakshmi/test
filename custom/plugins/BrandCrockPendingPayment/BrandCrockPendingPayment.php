<?php
/**
 * Plugin file (Bootstrap)
 *
 * Copyright (C) BrandCrock GmbH. All rights reserved
 *
 * If you have found this script useful a small
 * recommendation as well as a comment on our
 * home page(https://brandcrock.com/)
 * would be greatly appreciated.
 *
 * @author       BrandCrock
 * @package      BrandCrockPendingPayment
 */

namespace BrandCrockPendingPayment;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class BrandCrockPendingPayment extends Plugin
{
    /**
     * To install the plugin and create attributes
     *
     * @param object InstallContext $context
     *
     * @return null
     */
    public function install(InstallContext $context)
    {
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->update(
            's_order_attributes',
            'bc_due_date',
            'string',
        [
            'label' => 'Due date',
            'supportText' => 'payment due date',
            'helpText' => '',
            'translatable' => false,
            'displayInBackend' => true,
            'position' => 10,
            ]
        );
        $service->update('s_order_attributes', 'bc_over_due', 'string', []);
        $service->update('s_core_paymentmeans_attributes', 'bc_payment_due_date', 'string', [
            'label' => 'Due date',
            'supportText' => 'payment due date',
            'helpText' => '',
            'translatable' => false,
            'displayInBackend' => true,
            'position' => 10,
            ]);
        $service->update('s_order_attributes', 'bc_paid_amount', 'string', [
            'label' => 'payment Made',
            'supportText' => 'payment made ',
            'helpText' => '',
            'translatable' => false,
            'displayInBackend' => true,
            'position' => 10,
            ]);
        $service->update('s_order_attributes', 'bc_pending_amount', 'string', [
            'label' => 'payment expected',
            'supportText' => 'payment expected ',
            'helpText' => '',
            'translatable' => false,
            'displayInBackend' => true,
            'position' => 10,
            ]);
        $service->update('s_order_attributes', 'customer_reference_number', 'string', [
            'label' => 'Reference number',
            'supportText' => 'Reference number ',
            'helpText' => '',
            'translatable' => false,
            'displayInBackend' => true,
            'position' => 10,
            ]);
        $metaDataCache = Shopware()->Models()->getConfiguration()->getMetadataCacheImpl();
        $metaDataCache->deleteAll();
        Shopware()->Models()->generateAttributeModels(['s_order_attributes','s_core_paymentmeans_attributes']);
        $sql = 'CREATE TABLE IF NOT EXISTS bc_order_filter (
            id int(11) NOT NULL AUTO_INCREMENT,
            payment_type varchar(150) NOT NULL,
            ordernumber int(150) NOT NULL,
            overdue_date date NOT NULL,
            ordered_date date NOT NULL,
            shipped_date date NOT NULL,
            paymentname varchar(50) NOT NULL,
            overdue varchar(50) NOT NULL,
            orderID int(150) NOT NULL,
            PRIMARY KEY (id)
            )';
        Shopware()->Db()->query($sql);
    }
    /**
     * To uninstall the plugin and delete attributes
     *
     * @param object UninstallContext $context
     *
     * @return null
     */
    public function uninstall(UninstallContext $context)
    {
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->delete('s_order_attributes', 'bc_due_date');
        $service->delete('s_order_attributes', 'bc_over_due');
        $service->delete('s_order_attributes', 'bc_paid_amount');
        $service->delete('s_order_attributes', 'bc_pending_amount');
        $service->delete('s_order_attributes', 'customer_reference_number');
        $service->delete('s_core_paymentmeans_attributes', 'bc_payment_due_date');
        $metaDataCache = Shopware()->Models()->getConfiguration()->getMetadataCacheImpl();
        $metaDataCache->deleteAll();
        Shopware()->Models()->generateAttributeModels(['s_order_attributes','s_core_paymentmeans_attributes']);
    }
}
