<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/09/2017
 * Time: 15:54
 */
namespace Magento\Webpos\Test\Constraint\Location;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

class AssertLocationSuccessSaveMessage extends AbstractConstraint
{
	const SUCCESS_MESSAGE = 'Location was successfully saved';

	/**
	 * Check Success Save Message for Synonyms.
	 *
	 * @param LocationIndex $LocationIndex
	 * @return void
	 */
	public function processAssert(LocationIndex $locationIndex)
	{
		$actualMessage = $locationIndex->getMessagesBlock()->getSuccessMessage();
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