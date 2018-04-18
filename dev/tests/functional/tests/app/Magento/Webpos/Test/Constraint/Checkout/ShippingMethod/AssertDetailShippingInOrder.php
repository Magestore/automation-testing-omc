<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 18/01/2018
 * Time: 10:32
 */
namespace Magento\Webpos\Test\Constraint\Checkout\ShippingMethod;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertDetailShippingInOrder extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $shippingDescription, $orderId, $priceShipping)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->ordersHistory();
        sleep(2);
        $webposIndex->getOrderHistoryOrderList()->waitLoader();

        $webposIndex->getOrderHistoryOrderList()->search($orderId);
        $webposIndex->getOrderHistoryOrderList()->waitLoader();
        $webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();

        //Shipping
        \PHPUnit_Framework_Assert::assertEquals(
            $shippingDescription,
            $webposIndex->getOrderHistoryOrderViewContent()->getShippingDescription(),
            'Order Detail - Shipping discription is wrong'
            . "\nExpected: " . $shippingDescription
            . "\nActual: " . $webposIndex->getOrderHistoryOrderViewContent()->getShippingDescription()
        );

        \PHPUnit_Framework_Assert::assertEquals(
            floatval($priceShipping),
            floatval(str_replace('$','',$webposIndex->getOrderHistoryOrderViewFooter()->getShipping())),
            'Order Detail - Shipping price is wrong'
            . "\nExpected: " . $priceShipping
            . "\nActual: " . str_replace('$','',$webposIndex->getOrderHistoryOrderViewFooter()->getShipping())
        );

        $subtotal = str_replace('$','', $webposIndex->getOrderHistoryOrderViewFooter()->getSubTotal());
        $tax = str_replace('$','', $webposIndex->getOrderHistoryOrderViewFooter()->getTax());
        $totalExpected = floatval($priceShipping) + floatval($subtotal) + floatval($tax);
        $totalActual = floatval(str_replace('$','', $webposIndex->getOrderHistoryOrderViewFooter()->getGrandTotal()));

        \PHPUnit_Framework_Assert::assertEquals(
            $totalActual,
            $totalExpected,
            'Update total is not fit'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order Detail - Shipping method are correct";
    }
}