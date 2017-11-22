<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 13/09/2017
 * Time: 15:23
 */

namespace Magento\Webpos\Test\Constraint\Checkout;

use Magento\Mtf\Constraint\AbstractConstraint;

class AssertCheckoutOrderTest extends AbstractConstraint
{

	public function processAssert($result)
	{
		\PHPUnit_Framework_Assert::assertEquals(
			'Order has been created successfully',
			$result['notify-order-text'],
			'order place failed.'
		);
		\PHPUnit_Framework_Assert::assertNotFalse(
			$result['CP04-checkout-page-visibled'],
			'CP04 back to check out page failed'
		);
		\PHPUnit_Framework_Assert::assertNotFalse(
			$result['CP03-checkout-page-visibled'],
			'CP03 back to check out page failed'
		);
		\PHPUnit_Framework_Assert::assertNotFalse(
			$result['order-history-page-visibled'],
			'orders history page is not showed.'
		);
		\PHPUnit_Framework_Assert::assertNotFalse(
			$result['order-is-present'],
			'orders is not showed.'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$result['expect-order-status'],
			$result['order-status'],
			'CP05/CP06: Wrong status is displayed.'
			. "\nExpected: " . $result['expect-order-status']
			. "\nActual: " . $result['order-status']
		);
	}

	/**
	 * Text success save message is displayed
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Success';
	}
}