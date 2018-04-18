<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 18/01/2018
 * Time: 08:52
 */
namespace Magento\Webpos\Test\Constraint\Checkout\ShippingMethod;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCheckDisplayPanel extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $panelExpected)
    {
        $panelActual = $webposIndex->getCheckoutPlaceOrder()->isPanelShippingMethod();
        //Check blank
        \PHPUnit_Framework_Assert::assertEquals(
            $panelExpected,
            $panelActual,
            'Shipping panel doesn"t fit expected '
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Shipping panel fits with expected";
    }
}