<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 18/01/2018
 * Time: 10:32
 */
namespace Magento\Webpos\Test\Constraint\OnHoldOrder\Processing;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertDetailOrderHistory extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $name, $address, $phone, $orderId, $products)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->ordersHistory();
        $webposIndex->getOrderHistoryOrderList()->waitLoader();
        $webposIndex->getMsWebpos()->waitOrdersHistoryVisible();

        $webposIndex->getOrderHistoryOrderList()->search($orderId);
        $webposIndex->getOrderHistoryOrderList()->waitLoader();
        $webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();

        // Billing
        \PHPUnit_Framework_Assert::assertEquals(
            $name,
            $webposIndex->getOrderHistoryOrderViewContent()->getBillingName(),
            'Order Detail - Billing name is wrong'
            . "\nExpected: " . $name
            . "\nActual: " . $webposIndex->getOrderHistoryOrderViewContent()->getBillingName()
        );

        \PHPUnit_Framework_Assert::assertContains(
            $address,
            $webposIndex->getOrderHistoryOrderViewContent()->getBillingAddress(),
            'Order Detail - Billing address is wrong (Not check country)'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $phone,
            $webposIndex->getOrderHistoryOrderViewContent()->getBillingPhone(),
            'Order Detail - Billing phone is wrong'
            . "\nExpected: " . $phone
            . "\nActual: " . $webposIndex->getOrderHistoryOrderViewContent()->getBillingPhone()
        );

        //Shipping
        \PHPUnit_Framework_Assert::assertEquals(
            $name,
            $webposIndex->getOrderHistoryOrderViewContent()->getShippingName(),
            'Order Detail - Shipping name is wrong'
            . "\nExpected: " . $name
            . "\nActual: " . $webposIndex->getOrderHistoryOrderViewContent()->getShippingName()
        );

        \PHPUnit_Framework_Assert::assertContains(
            $address,
            $webposIndex->getOrderHistoryOrderViewContent()->getShippingAddress(),
            'Order Detail - Shipping address is wrong (Not check country)'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $phone,
            $webposIndex->getOrderHistoryOrderViewContent()->getShippingPhone(),
            'Order Detail - Shipping phone is wrong'
            . "\nExpected: " . $phone
            . "\nActual: " . $webposIndex->getOrderHistoryOrderViewContent()->getShippingPhone()
        );

        //Check product item
        for ($i = 0; $i < count($products); ++$i)
        {
            \PHPUnit_Framework_Assert::assertEquals(
                $webposIndex->getOrderHistoryOrderViewContent()->getNameProductOrderTo($i+1),
                $products[$i]['name'],
                'Name product is not correct'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $webposIndex->getOrderHistoryOrderViewContent()->getPriceProductByOrderTo($i+1),
                floatval($products[$i]['price']),
                'Price product is not correct'
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
        return "Order Detail - Shipping method are correct";
    }
}