<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/09/2017
 * Time: 13:12
 */

namespace Magento\Webpos\Test\Constraint\Settings\Account;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertBlankSpace extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getAccount()->getNameErrorMessage()->isVisible(),
			'Display name require message is not showed'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			'This is a required field.',
			$webposIndex->getAccount()->getNameErrorMessage()->getText(),
			'Display Require message is wrong'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Require Message displayed';
	}
}