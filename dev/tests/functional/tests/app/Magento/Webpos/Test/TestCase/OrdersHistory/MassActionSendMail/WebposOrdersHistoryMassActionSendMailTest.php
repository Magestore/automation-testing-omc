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
 * Precondition and setup steps:
 * OH19 & OH20 & OH21 & OH22 & OH23
 * 1. Login webpos as a staff
 * 2. Create an order successfully
 *
 * OH19
 * Steps:
 * 1. Go to order details page
 * 2. Click on icon on the top of the right
 * 3. Click on Send email action
 * Acceptance Criteria:
 * Display Send email popup includding:
 * - button: Cancel, Send
 * - Texbox to enter email address
 * - Automatically fill customer's email address into textbox
 *
 * OH20
 * Steps:
 * 1. Click to [Send email]
 * 2. Click on [Cancel] button
 * Acceptance Criteria:
 * Close Send email popup
 *
 * OH21
 * Steps:
 * 1. Click to [Send email]
 * 2. Click on [Send] button
 * Acceptance Criteria:
 * 1 Close Send email popup
 * 2. Order email will be sent to customer's email address
 * 3. A new notification will be display on notification icon
 *
 * OH22
 * Steps:
 * 1. Click to [Send email]
 * 2. Enter different email address into textbox
 * Acceptance Criteria:
 * 1 Close Send email popup
 * 2. Order email will be sent to email address just entered
 *
 * OH23
 * Steps:
 * 1. Click to [Send email]
 * 2. Enter an invalid email into textbox
 * Acceptance Criteria:
 * Show message "Email is invalid"
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