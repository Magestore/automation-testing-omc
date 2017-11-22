<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/09/2017
 * Time: 16:02
 */

namespace Magento\Webpos\Test\Constraint\Settings\Login;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertLoginSuccess extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		sleep(5);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getFirstScreen()->isVisible(),
			'Login failed'
		);
		sleep(5);
		while ($webposIndex->getFirstScreen()->isVisible()) {}
		sleep(2);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutPage()->isVisible(),
			"Checkout page isn't showed"
		);
	}

	/**
	 * Text success save message is displayed
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Login success';
	}
}