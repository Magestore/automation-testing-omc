<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 01/02/2018
 * Time: 14:01
 */
namespace Magento\Webpos\Test\Constraint\OnHoldOrder\HoldOrder;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCheckRowTotal extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $products)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->onHoldOrders();
        sleep(1);

        //Check row total item
        for ($i=0; $i<count($products); ++$i)
        {
            $rowTotalActual = str_replace('$','',$webposIndex->getOnHoldOrderOrderViewContent()->getRowTotalProductByOrderTo($i+1));
            $tax = str_replace('$','',$webposIndex->getOnHoldOrderOrderViewContent()->getTaxAmountProductByOrderTo($i+1));
            $price = str_replace('$','',$webposIndex->getOnHoldOrderOrderViewContent()->getPriceProductByOrderTo($i+1));
            $discount = str_replace('$','',$webposIndex->getOnHoldOrderOrderViewContent()->getDiscountProductByOrderTo($i+1));
            $rowTotalExpected = $price + $tax - $discount;
            \PHPUnit_Framework_Assert::assertEquals(
                $rowTotalExpected,
                $rowTotalActual,
                'Row total is not correct, rowTotalExpected is : $'.$rowTotalExpected.' and rowTotalActual in table is : $'.$rowTotalActual
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
        return "Row total is correct";
    }
}