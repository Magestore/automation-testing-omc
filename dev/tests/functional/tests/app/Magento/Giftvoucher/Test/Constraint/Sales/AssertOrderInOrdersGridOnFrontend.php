<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\Constraint\Sales;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Customer\Test\Page\CustomerAccountIndex;
use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Sales\Test\Page\OrderHistory;
use Magento\Mtf\ObjectManager;

/**
 * Assert that order is present in Orders grid on frontend.
 */
class AssertOrderInOrdersGridOnFrontend extends \Magento\Sales\Test\Constraint\AssertOrderInOrdersGridOnFrontend
{

    /**
     * Assert that order is present in Orders grid on frontend.
     *
     * @param OrderInjectable $order
     * @param Customer $customer
     * @param ObjectManager $objectManager
     * @param CustomerAccountIndex $customerAccountIndex
     * @param OrderHistory $orderHistory
     * @param string $status
     * @param string $orderId
     * @param string|null $statusToCheck
     * @return void
     */
    public function processAssert(
        OrderInjectable $order,
        Customer $customer,
        ObjectManager $objectManager,
        CustomerAccountIndex $customerAccountIndex,
        OrderHistory $orderHistory,
        $status,
        $orderId = '',
        $statusToCheck = null
    ) {
        $filter = [
            'id' => $order->hasData('increment_id') ? $order->getIncrementId() : $orderId,
            'status' => $statusToCheck === null ? $status : $statusToCheck,
        ];

        $objectManager->create(
            'Magento\Customer\Test\TestStep\LoginCustomerOnFrontendStep',
            ['customer' => $customer]
        )->run();
        $customerAccountIndex->getAccountMenuBlock()->openMenuItem('My Orders');
        $errorMessage = implode(', ', $filter);
        \PHPUnit_Framework_Assert::assertTrue(
            $orderHistory->getOrderHistoryBlock()->isOrderVisible($filter),
            'Order with following data \'' . $errorMessage . '\' is absent in Orders block on frontend.'
        );
    }
}
