<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 07/12/2017
 * Time: 14:07
 */

namespace Magento\Webpos\Test\Constraint\OnHoldOrder\HoldOrder;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertOrderDetailShipAndBillAddressAreCorrect
 * @package Magento\Webpos\Test\Constraint\OnHoldOrder\HoldOrder
 */
class AssertOrderDetailShipAndBillAddressAreCorrect extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $name, $address, $phone)
	{
		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->onHoldOrders();
        $webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $webposIndex->getOrderHistoryOrderList()->waitLoader();
        $webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $webposIndex->getOrderHistoryOrderList()->waitForFirstOrderVisible();
        $webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
//		$name = $address->getFirstname().' '.$address->getLastname();
//		$addressText = $address->getCity().', '.$address->getRegionId().', '.$address->getPostcode().', ';

		// Billing
		\PHPUnit_Framework_Assert::assertEquals(
			$name,
			$webposIndex->getOnHoldOrderOrderViewContent()->getBillingName(),
			'Order Detail - Billing name is wrong'
			. "\nExpected: " . $name
			. "\nActual: " . $webposIndex->getOnHoldOrderOrderViewContent()->getBillingName()
		);

		\PHPUnit_Framework_Assert::assertContains(
			$address,
			$webposIndex->getOnHoldOrderOrderViewContent()->getBillingAddress(),
			'Order Detail - Billing address is wrong (Not check country)'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$phone,
			$webposIndex->getOnHoldOrderOrderViewContent()->getBillingPhone(),
			'Order Detail - Billing phone is wrong'
			. "\nExpected: " . $phone
			. "\nActual: " . $webposIndex->getOnHoldOrderOrderViewContent()->getBillingPhone()
		);

		//Shipping
		\PHPUnit_Framework_Assert::assertEquals(
			$name,
			$webposIndex->getOnHoldOrderOrderViewContent()->getShippingName(),
			'Order Detail - Shipping name is wrong'
			. "\nExpected: " . $name
			. "\nActual: " . $webposIndex->getOnHoldOrderOrderViewContent()->getShippingName()
		);

		\PHPUnit_Framework_Assert::assertContains(
			$address,
			$webposIndex->getOnHoldOrderOrderViewContent()->getShippingAddress(),
			'Order Detail - Shipping address is wrong (Not check country)'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$phone,
			$webposIndex->getOnHoldOrderOrderViewContent()->getShippingPhone(),
			'Order Detail - Shipping phone is wrong'
			. "\nExpected: " . $phone
			. "\nActual: " . $webposIndex->getOrderHistoryOrderViewContent()->getShippingPhone()
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
		return "Order Detail - Ship And Bill Address are correct";
	}
}