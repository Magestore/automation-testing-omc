<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/09/2017
 * Time: 08:35
 */

namespace Magento\Webpos\Test\Constraint\Pos;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposPosIndex;

class AssertPosMassDeleteInGrid extends AbstractConstraint
{
	/**
	 * Assert that pos which haven't been deleted are present in Pos grid
	 *
	 * @param WebposPosIndex $webposPosIndex
	 * @param AssertPosInGrid $assertPosInGrid
	 * @param $webposPosQtyToDelete
	 * @param $webposPos
	 */
	public function processAssert(
		WebposPosIndex $webposPosIndex,
		AssertPosInGrid $assertPosInGrid,
		$webposPosQtyToDelete,
		$webposPos
	) {
		$webposPos = array_slice($webposPos, $webposPosQtyToDelete);
		foreach ($webposPos as $item) {
			$assertPosInGrid->processAssert($item, $webposPosIndex);
		}
	}

	/**
	 * Text success exist Pos in grid
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Pos are present in Pos grid.';
	}
}