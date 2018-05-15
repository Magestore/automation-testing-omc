<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 20/01/2018
 * Time: 12:22
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Permission;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertPlaceOrderSuccess extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $orderId)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->ordersHistory();
        $webposIndex->getOrderHistoryOrderList()->waitLoader();
        $webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $webposIndex->getOrderHistoryOrderList()->search($orderId);
        $webposIndex->getOrderHistoryOrderList()->waitLoader();

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