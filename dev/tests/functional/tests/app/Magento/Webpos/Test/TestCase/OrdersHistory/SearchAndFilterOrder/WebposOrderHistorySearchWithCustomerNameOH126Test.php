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

class WebposOrderHistorySearchWithCustomerNameOH126Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject(WebposIndex $webposIndex)
    {
        $this->webposIndex = $webposIndex;
    }

    public function test(OrderInjectable $order)
    {
        // Create order
        $data = $this->objectManager->getInstance()->create(
            'Magento\Sales\Test\TestStep\CreateOrderStep',
            ['order' => $order]
        )->run();
        $order = $data['order'];
        // Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        // Go to Order History
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->search($order->getCustomerId()->getFirstName() . ' ' .$order->getCustomerId()->getLastName() );
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        sleep(3);
        $this->assertTrue(
            $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->isVisible(),
            'No result found.'
        );
    }
}