<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 07/12/2017
 * Time: 14:07
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\Customer;


use Magento\Customer\Test\Fixture\Address;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertOrderDetailShipAndBillAddressAreCorrect extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $name, $address, $phone, $orderId)
	{
		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->ordersHistory();
		sleep(2);
		$webposIndex->getOrderHistoryOrderList()->waitLoader();

		$webposIndex->getOrderHistoryOrderList()->search($orderId);
        $webposIndex->getOrderHistoryOrderList()->waitLoader();
        $webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
//		$name = $address->getFirstname().' '.$address->getLastname();
//		$addressText = $address->getCity().', '.$address->getRegionId().', '.$address->getPostcode().', ';

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