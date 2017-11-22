<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 30/10/2017
 * Time: 09:05
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\Shift;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShiftIsInShiftList extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, Shift $shift, $action = '')
	{
		$webposIndex->open();
		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->registerShift();
		sleep(3);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getRegisterShift()->getFirstShift()->isVisible(),
			'Synchronization - Shift - '.$action.' - Shift list is empty'
		);
		$webposIndex->getRegisterShift()->getFirstShift()->click();
		\PHPUnit_Framework_Assert::assertEquals(
			(float)$shift->getTotalSales(),
			(float) $webposIndex->getRegisterShift()->getTotalSales(),
			'Synchronization - Shift - '.$action.' - Total Sale is wrong'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$shift->getOpenedNote(),
			$webposIndex->getRegisterShift()->getOpenedNote(),
			'Synchronization - Shift - '.$action.' - Opened Note is wrong'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$shift->getClosedNote(),
			$webposIndex->getRegisterShift()->getClosedNote(),
			'Synchronization - Shift - '.$action.' - Closed Note is wrong'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Shift - Shift is shown correctly in Shift List";
	}
}