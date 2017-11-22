<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/09/2017
 * Time: 08:33
 */

namespace Magento\Webpos\Test\Constraint\Pos;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposPosIndex;

class AssertPosMassDeleteSuccessMessage extends AbstractConstraint
{
	/**
	 * Message that appears after deletion via mass actions
	 */
	const SUCCESS_DELETE_MESSAGE = 'A total of %d record(s) were deleted.';

	/**
	 * Assert that message "A total of "x" record(s) were deleted."
	 *
	 * @param $webposPosQtyToDelete
	 * @param WebposPosIndex $webposPosIndex
	 * @return void
	 */
	public function processAssert($webposPosQtyToDelete, WebposPosIndex $webposPosIndex)
	{
		\PHPUnit_Framework_Assert::assertEquals(
			sprintf(self::SUCCESS_DELETE_MESSAGE, $webposPosQtyToDelete),
			$webposPosIndex->getMessagesBlock()->getSuccessMessage(),
			'Wrong delete message is displayed.'
		);
	}

	/**
	 * Returns a string representation of the object
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Mass delete pos message is displayed.';
	}
}