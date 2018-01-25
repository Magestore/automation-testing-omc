<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/25/2018
 * Time: 9:44 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Address;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertAddressInOrdersHistory extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $shippingAddress, $billingAddress)
    {
        $customerNameShip = $webposIndex->getOrderHistoryOrderViewContent()->getShippingName();
        $customerAddressShip = $webposIndex->getOrderHistoryOrderViewContent()->getShippingAddress();
        $customerTelephoneShip = $webposIndex->getOrderHistoryOrderViewContent()->getShippingPhone();
        \PHPUnit_Framework_Assert::assertEquals(
            $shippingAddress['name'],
            $customerNameShip,
            'Shipping address - Customer Name is wrong'
            . "\nExpected: " . $shippingAddress['name']
            . "\nActual: " . $customerNameShip
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $shippingAddress['address'],
            $customerAddressShip,
            'Shipping address - Customer address is wrong'
            . "\nExpected: " . $shippingAddress['address']
            . "\nActual: " . $customerAddressShip
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $shippingAddress['telephone'],
            $customerTelephoneShip,
            'Shipping address - Customer telephone is wrong'
            . "\nExpected: " . $shippingAddress['telephone']
            . "\nActual: " . $customerTelephoneShip
        );
        $customerNameBill = $webposIndex->getOrderHistoryOrderViewContent()->getBillingName();
        $customerAddressBill = $webposIndex->getOrderHistoryOrderViewContent()->getBillingAddress();
        $customerTelephoneBill = $webposIndex->getOrderHistoryOrderViewContent()->getBillingPhone();
        \PHPUnit_Framework_Assert::assertEquals(
            $billingAddress['name'],
            $customerNameBill,
            'Billing address - Customer Name is wrong'
            . "\nExpected: " . $billingAddress['name']
            . "\nActual: " . $customerNameBill
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $billingAddress['address'],
            $customerAddressBill,
            'Billing address - Customer address is wrong'
            . "\nExpected: " . $billingAddress['address']
            . "\nActual: " . $customerAddressBill
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $billingAddress['telephone'],
            $customerTelephoneBill,
            'Billing address - Customer telephone is wrong'
            . "\nExpected: " . $billingAddress['telephone']
            . "\nActual: " . $customerTelephoneBill
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Shipping and Billing Address are correct.';
    }
}