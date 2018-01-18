<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 18/01/2018
 * Time: 09:45
 */
namespace Magento\Webpos\Test\Constraint\Checkout\ShippingMethod;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertUpdatePriceShipping extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $priceShipping)
    {
            \PHPUnit_Framework_Assert::assertEquals(
                $webposIndex->getCheckoutWebposCart()->getPriceShipping(),
                floatval($priceShipping),
                'Price shipping is not update'
            );

    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "ShippingMethods are correct";
    }
}