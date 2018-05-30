<?php

/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/24/2018
 * Time: 1:54 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\MassActionSendMail;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\TestCase\Injectable;
use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOrdersHistoryMassActionSendMailTest
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionSendMail
 */
class WebposOrdersHistoryMassActionSendMailTest extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var Customer $customer
     */
    protected $customer;

    /**
     * @param WebposIndex $webposIndex
     * @param Customer $customer
     */
    public function __inject(WebposIndex $webposIndex, Customer $customer)
    {
        $this->webposIndex = $webposIndex;
        $this->customer = $customer;
    }

    /**
     * @param OrderInjectable $order
     * @param null $action
     * @return array
     */
    public function test(
        OrderInjectable $order,
        $action = null
    )
    {
        // Preconditions
        $order->persist();
        $this->customer = $order->getData('customer_id');
        $customerEmail = $this->customer->getEmail();

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        // Step
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();

        $this->webposIndex->getOrderHistoryOrderViewHeader()->openAddOrderNote();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Send Email')->click();

        if ($action === 'DifferentInput') {
            $customerEmail = 'magestore123@example.com';
        } elseif ($action === 'InvalidInput') {
            $customerEmail = 'magestore';
        }

        return [
            'action' => $action,
            'customerEmail' => $customerEmail
        ];
    }
}