<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/09/2017
 * Time: 08:43
 */

namespace Magento\Webpos\Test\Constraint\Pos;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposPosIndex;

class AssertPosMassDeleteNotInGrid extends AbstractConstraint
{
	/**
	 * Asserts that mass deleted pos are not in pos's grid
	 *
	 * @param WebposPosIndex $webposPosIndex
	 * @param AssertPosNotInGrid $assertPosNotInGrid
	 * @param $webposPosQtyToDelete
	 * @param $webposPos
	 */
	public function processAssert(
		WebposPosIndex $webposPosIndex,
		AssertPosNotInGrid $assertPosNotInGrid,
		$webposPosQtyToDelete,
		$webposPos
	) {
		for ($i = 0; $i < $webposPosQtyToDelete; $i++) {
			$assertPosNotInGrid->processAssert($webposPos[$i], $webposPosIndex);
		}
	}

	/**
	 * Success message if Pos not in grid
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Deleted pos are absent in Pos grid.';
	}
}