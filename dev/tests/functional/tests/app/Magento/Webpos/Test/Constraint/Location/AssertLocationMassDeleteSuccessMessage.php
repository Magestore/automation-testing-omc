<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 07/09/2017
 * Time: 14:36
 */

namespace Magento\Webpos\Test\Constraint\Location;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

class AssertLocationMassDeleteSuccessMessage extends AbstractConstraint
{
	/**
	 * Message that appears after deletion via mass actions
	 */
	const SUCCESS_DELETE_MESSAGE = 'A total of %d record(s) were deleted.';

	/**
	 * Assert that message "A total of "x" record(s) were deleted."
	 *
	 * @param $locationQtyToDelete
	 * @param LocationIndex $locationIndex
	 * @return void
	 */
	public function processAssert($locationQtyToDelete, LocationIndex $locationIndex)
	{
		\PHPUnit_Framework_Assert::assertEquals(
			sprintf(self::SUCCESS_DELETE_MESSAGE, $locationQtyToDelete),
			$locationIndex->getMessagesBlock()->getSuccessMessage(),
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
		return 'Mass delete locations message is displayed.';
	}
}