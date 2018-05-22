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
/**
 * Class AssertEditDiscountCustomPrice
 * @package Magento\Webpos\Test\Constraint\Adminhtml\Staff\Permission
 */
class AssertEditDiscountCustomPrice extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $discount, $i)
    {
        $priceActual = $webposIndex->getCheckoutCartItems()->getPriceCartItemByOrderTo($i);
        $priceOrigin = $webposIndex->getCheckoutCartItems()->getOriginPriceCartItemByOrderTo($i);
        $priceExpected = floatval($priceOrigin) - floatval($priceOrigin) * floatval($discount) * 0.01;

        \PHPUnit_Framework_Assert::assertEquals(
            $priceExpected,
            floatval($priceActual),
            'Price is incorrect'
        );

    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Price is correct";
    }
}