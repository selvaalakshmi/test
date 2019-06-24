<?php
/**
 * The Backend file
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
namespace BrandCrockPendingPayment\Subscriber;

use Enlight\Event\SubscriberInterface;

class Backend implements SubscriberInterface
{
    /**
     * To get the subscriber event
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Controllers_Backend_Order::saveAction::after' => 'onSaveOrder'
        ];
    }
    /**
     * To update the order attributes
     *
     * @return null
     */
    public function onSaveOrder()
    {
        $view = Shopware()->Front()->Request()->getPost();
        $ordNumber = $view['number'];
        $paidDate = $view['clearedDate'];
        if (empty($paidDate)) {
            return null;
        }
        $clearedDate = date('Y-m-d', strtotime($paidDate));
        $sql = "select overdue_date from bc_order_filter where ordernumber = $ordNumber";
        $bc_result = Shopware()->Db()->fetchAll($sql);
        $overdue_dateRes = $bc_result['0']['overdue_date'];

        if ($clearedDate == $overdue_dateRes || $clearedDate <= $overdue_dateRes) {
            $overdue = '1';
            Shopware()->Container()->get('dbal_connection')->executeQuery('UPDATE bc_order_filter SET overdue = ? where ordernumber= ?', [
            $overdue,
            $ordNumber,
            ]);
        } else {
            $overdue = '0';
            Shopware()->Container()->get('dbal_connection')->executeQuery('UPDATE bc_order_filter SET overdue = ? where ordernumber= ?', [
            $overdue,
            $ordNumber,
            ]);
        }
    }
}
