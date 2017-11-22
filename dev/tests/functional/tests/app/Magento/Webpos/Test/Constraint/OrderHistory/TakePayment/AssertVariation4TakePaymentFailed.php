<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 16/10/2017
 * Time: 13:58
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\TakePayment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertVariation4TakePaymentFailed extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		sleep(1);
		\PHPUnit_Framework_Assert::assertEquals(
			'Please select a payment method!',
			$webposIndex->getModal()->getPopupMessage(),
			'Error Popup message is not showed'
		);

		$webposIndex->getModal()->getOkButton()->click();
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Take Payment - Don't select payment method : Pass";
	}
}