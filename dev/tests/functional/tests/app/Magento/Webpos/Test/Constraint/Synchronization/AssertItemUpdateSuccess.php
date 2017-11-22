<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/10/2017
 * Time: 13:47
 */

namespace Magento\Webpos\Test\Constraint\Synchronization;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertItemUpdateSuccess extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $text, $action = '')
	{
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getSynchronization()->getItemRowProgress($text)->isVisible(),
			'Synchronization - '.$text.' - '.$action.' - progress bar is not shown'
		);
		while($webposIndex->getSynchronization()->getItemRowProgress($text)->isVisible()){}
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getSynchronization()->getItemRowSuccess($text)->isVisible(),
			'Synchronization - '.$text.' - '.$action.' - Success icon is not shown'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Item Update/Reload Success";
	}
}