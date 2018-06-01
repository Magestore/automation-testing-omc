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

class AssertDiscountWholeCartPercentage extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $orderId, $discount, $total)
    {
        $discount = $discount * $total * 0.01;
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->ordersHistory();
        $webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $webposIndex->getOrderHistoryOrderList()->waitLoader();
        $webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        sleep(1);
        $webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        $webposIndex->getOrderHistoryOrderList()->waitLoader();
        sleep(2);
        $discountActual = str_replace('-$', '', $webposIndex->getOrderHistoryOrderViewFooter()->getDiscount());
        \PHPUnit_Framework_Assert::assertEquals(
            floatval($discount),
            floatval($discountActual),
            'Discount does not apply by role'
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
        return "Discount apply whole cart by role";
    }
}