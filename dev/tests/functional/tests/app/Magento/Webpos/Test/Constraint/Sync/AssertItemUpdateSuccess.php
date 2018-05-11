<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 26/02/2018
 * Time: 11:21
 */

namespace Magento\Webpos\Test\Constraint\Sync;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertItemUpdateSuccess
 * @package Magento\Webpos\Test\Constraint\Sync
 */
class AssertItemUpdateSuccess extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $text, $action = '')
	{
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getSyncTabData()->getItemRowProgress($text)->isVisible(),
			'Synchronization - '.$text.' - '.$action.' - progress bar is not shown'
		);
		while($webposIndex->getSyncTabData()->getItemRowProgress($text)->isVisible()){}
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getSyncTabData()->getItemRowSuccess($text)->isVisible(),
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