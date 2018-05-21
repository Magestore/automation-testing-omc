<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 16:45
 */

namespace Magento\Webpos\Test\Constraint\Pos;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposPosIndex;

class AssertPosSuccessDeleteMessage extends AbstractConstraint
{
	const SUCCESS_MESSAGE = 'Pos was successfully deleted';

	public function processAssert(PosIndex $posIndex)
	{
		$actualMessage = $posIndex->getMessagesBlock()->getSuccessMessage();
		\PHPUnit_Framework_Assert::assertEquals(
			self::SUCCESS_MESSAGE,
			$actualMessage,
			'Wrong success message is displayed.'
			. "\nExpected: " . self::SUCCESS_MESSAGE
			. "\nActual: " . $actualMessage
		);
	}

	/**
	 * Text success save message is displayed
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Assert that success message is displayed.';
	}
}