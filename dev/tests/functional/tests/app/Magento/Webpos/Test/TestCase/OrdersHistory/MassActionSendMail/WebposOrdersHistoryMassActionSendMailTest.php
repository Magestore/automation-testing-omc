<?php

/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/24/2018
 * Time: 1:54 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\MassActionSendMail;

use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\TestCase\Injectable;

/**
 * Class WebposOrdersHistoryMassActionSendMailTest
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionSendMail
 */
class WebposOrdersHistoryMassActionSendMailTest extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var Customer
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

        // Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        // Step
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();

        $this->webposIndex->getOrderHistoryOrderViewHeader()->openAddOrderNote();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Send Email')->click();

        if ($action === 'DifferentInput'){
            $customerEmail = 'magestore123@example.com';
        }elseif ($action === 'InvalidInput'){
            $customerEmail = 'magestore';
        }

        return [
            'action' => $action,
            'customerEmail' => $customerEmail
        ];
    }
}