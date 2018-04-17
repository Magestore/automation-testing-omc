<?php
namespace Magento\Webpos\Test\Constraint\Staff;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertOrderOnlyCreatedByStaff extends AbstractConstraint
{

    /**
     * @param WebposIndex $webposIndex
     * @param $orderId
     */
    public function processAssert(WebposIndex $webposIndex, $orderIds)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->ordersHistory();
        sleep(1);
        $webposIndex->getOrderHistoryOrderList()->waitLoader();

        $items = $webposIndex->getOrderHistoryOrderList()->getAllOrderItems();
        \PHPUnit_Framework_Assert::assertEquals(
            count($orderIds),
            count($items),
            'Order Items is incorrect'
        );

        for ($i=0; $i<count($orderIds); ++$i)
        {
            $webposIndex->getOrderHistoryOrderList()->search($orderIds[$i]);
            $webposIndex->getMsWebpos()->clickOutsidePopup();
            $webposIndex->getOrderHistoryOrderList()->waitLoader();
            sleep(1);
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryOrderList()->getFirstOrder()->isVisible(),
                'Order Items is incorrect'
            );
        }

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