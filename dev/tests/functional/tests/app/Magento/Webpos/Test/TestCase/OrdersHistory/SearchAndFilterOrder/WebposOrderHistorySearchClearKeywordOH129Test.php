<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/6/2018
 * Time: 9:38 AM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\SearchAndFilterOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistorySearchClearKeywordOH129Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject(WebposIndex $webposIndex)
    {
        $this->webposIndex = $webposIndex;
    }

    public function test()
    {
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
        $this->webposIndex->getOrderHistoryOrderList()->search('dadasdasdasdasdasdasd');
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->assertFalse(
            $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->isVisible(),
            'Search with incorrect data found result.'
        );
        $this->assertFalse(
            $this->webposIndex->getOrderHistoryOrderViewContent()->isVisible(),
            'Order view detail is visible.'
        );
        $this->webposIndex->getOrderHistoryOrderList()->search('');
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        sleep(1);
        $this->assertTrue(
            $this->webposIndex->getOrderHistoryOrderList()->orderListIsVisible(),
            'List order is not visible.'
        );

    }
}