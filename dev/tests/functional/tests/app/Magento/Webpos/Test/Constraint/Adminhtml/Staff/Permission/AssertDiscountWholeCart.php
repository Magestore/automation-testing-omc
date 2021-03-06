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

class AssertDiscountWholeCart extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $orderId, $discount)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->ordersHistory();
        $webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $webposIndex->getOrderHistoryOrderList()->waitLoader();
        $webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $webposIndex->getOrderHistoryOrderList()->search($orderId);
        $webposIndex->getOrderHistoryOrderList()->waitLoader();

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