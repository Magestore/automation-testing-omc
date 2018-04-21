<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 16/01/2018
 * Time: 17:18
 */
namespace Magento\Webpos\Test\Constraint\Checkout\ShippingMethod;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShippingMethod extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $idShippingMethods)
    {
            foreach (explode(', ',$idShippingMethods) as $id)
            {
                \PHPUnit_Framework_Assert::assertTrue(
                    $webposIndex->getCheckoutPlaceOrder()->isMethodVisible($id),
                    'Shipping method with id : '.$id.' doesn\'t display.'
                );
            }
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