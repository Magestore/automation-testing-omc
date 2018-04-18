<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 01/02/2018
 * Time: 14:26
 */
namespace Magento\Webpos\Test\Constraint\OnHoldOrder\HoldOrder;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCheckDiscountWhole extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $discount)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->onHoldOrders();
        sleep(1);

        //Check discount
        $discountActual = str_replace('$','',$webposIndex->getOnHoldOrderOrderViewFooter()->getRowValue('Discount'));
        $discountActual = str_replace('-','',$discountActual);
        \PHPUnit_Framework_Assert::assertEquals(
            floatval($discount),
            floatval($discountActual),
            'Discount is not correct'
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
        return "Discount is correct";
    }
}