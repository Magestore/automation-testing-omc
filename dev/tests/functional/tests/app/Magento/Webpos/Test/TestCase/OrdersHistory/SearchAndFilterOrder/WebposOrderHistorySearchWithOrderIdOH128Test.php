<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/6/2018
 * Time: 9:38 AM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\SearchAndFilterOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOrderHistorySearchWithOrderIdOH128Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\SearchAndFilterOrder
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Go to Orders history page
 * Steps:
 * 1. Enter correct order id into search textbox
 * 2. Enter or click on Search icon
 * Acceptance Criteria:
 * Order list shows the orders have order id matchs or contains keyword
 */
class WebposOrderHistorySearchWithOrderIdOH128Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(WebposIndex $webposIndex)
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param OrderInjectable $order
     */
    public function test(OrderInjectable $order)
    {
        // Create order
        $data = $this->objectManager->getInstance()->create(
            'Magento\Sales\Test\TestStep\CreateOrderStep',
            ['order' => $order]
        )->run();
        $order = $data['order'];
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        // Go to Order History
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->search($order->getId());
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        sleep(3);
        $this->assertTrue(
            $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->isVisible(),
            'No result found.'
        );
    }
}