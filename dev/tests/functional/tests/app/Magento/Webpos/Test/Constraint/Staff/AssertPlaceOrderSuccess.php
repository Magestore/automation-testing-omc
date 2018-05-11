<?php
namespace Magento\Webpos\Test\Constraint\Staff;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertPlaceOrderSuccess extends AbstractConstraint
{

    /**
     * @param WebposIndex $webposIndex
     * @param $orderId
     */
    public function processAssert(WebposIndex $webposIndex, $orderId)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->ordersHistory();
        sleep(1);
        $webposIndex->getOrderHistoryOrderList()->waitLoader();

        $webposIndex->getOrderHistoryOrderList()->search($orderId);
        $webposIndex->getOrderHistoryOrderList()->waitLoader();
        sleep(1);
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryOrderList()->getFirstOrder()->isVisible(),
            'Place order is not successfully'
        );
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->checkout();
        sleep(1);
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Place order is successfully";
    }
}