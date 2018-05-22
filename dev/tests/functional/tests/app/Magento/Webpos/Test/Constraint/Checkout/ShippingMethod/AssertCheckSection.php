<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 18/01/2018
 * Time: 07:47
 */
namespace Magento\Webpos\Test\Constraint\Checkout\ShippingMethod;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertCheckSection
 * @package Magento\Webpos\Test\Constraint\Cart\ShippingMethod
 */
class AssertCheckSection extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $tagExpected, $titleExpected, $idSelected)
    {
        $tagActual = $webposIndex->getCheckoutPlaceOrder()->isShippingMethod();
        //Check blank
        \PHPUnit_Framework_Assert::assertEquals(
            $tagExpected,
            $tagActual,
            'Shipping blank doesn"t fit expected '
        );
        sleep(1);
        $tagActual = $webposIndex->getCheckoutWebposCart()->isDisplayShippingOnCart();
        \PHPUnit_Framework_Assert::assertEquals(
            $tagExpected,
            $tagActual,
            'Shipping label doen"s display on cart '
        );

        //Check title shipping, selected shipping
        if ($tagExpected)
        {
            $titleActual = $webposIndex->getCheckoutPlaceOrder()->getTitleShippingSection();
            \PHPUnit_Framework_Assert::assertEquals(
                $titleExpected,
                $titleActual,
                'Expected title: "'.$titleExpected.'" not fit Actual title: "'.$titleActual.'"'
            );

            $tagSelected = $webposIndex->getCheckoutPlaceOrder()->isSelectedShippingMethod($idSelected);
            \PHPUnit_Framework_Assert::assertTrue(
                $tagSelected,
                'Shipping method is no selected'
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
        return "Shipping section fits";
    }
}