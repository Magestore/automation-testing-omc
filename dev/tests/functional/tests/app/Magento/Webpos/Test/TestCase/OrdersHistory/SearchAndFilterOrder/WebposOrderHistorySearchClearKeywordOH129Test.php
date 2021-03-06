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

/**
 * Class WebposOrderHistorySearchClearKeywordOH129Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\SearchAndFilterOrder
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Go to Orders history page
 * Steps:
 * 1. Search order with any keyword > click on Search icon
 * 2. Delete keyword > Click on Search icon
 * Acceptance Criteria:
 * Back to default list, all orders will be shown on list
 */
class WebposOrderHistorySearchClearKeywordOH129Test extends Injectable
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
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        sleep(1);
        $this->assertTrue(
            $this->webposIndex->getOrderHistoryOrderList()->orderListIsVisible(),
            'List order is not visible.'
        );

    }
}