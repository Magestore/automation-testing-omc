<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 01/02/2018
 * Time: 15:29
 */
namespace Magento\Webpos\Test\Constraint\OnHoldOrder\HoldOrder;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCheckFeeShipping extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $feeShipping)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->onHoldOrders();
        sleep(1);

        //Check comment
        $feeShippingActual = floatval(str_replace('$','',$webposIndex->getOnHoldOrderOrderViewFooter()->getRowValue('Shipping')));
        \PHPUnit_Framework_Assert::assertEquals(
            $feeShipping,
            $feeShippingActual,
            'Fee shipping is not correct'
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
        return "Fee shipping is correct";
    }
}