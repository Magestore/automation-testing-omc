<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/09/2017
 * Time: 14:04
 */

namespace Magento\Webpos\Test\Constraint\Settings;



use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertLoginPageIsVisible extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getLoginForm()->isVisible(),
			'Login Form is not visibled'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getLoginForm()->getLogo()->isVisible(),
			'Logo is not visibled'
		);
	}

	/**
	 * Text success save message is displayed
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Login page is visibled correctly';
	}
}