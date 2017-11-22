<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 07/09/2017
 * Time: 14:53
 */

namespace Magento\Webpos\Test\Constraint\Location;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

class AssertLocationMassDeleteNotInGrid extends AbstractConstraint
{
	/**
	 * Asserts that mass deleted location are not in location's grid
	 *
	 * @param LocationIndex $locationIndex
	 * @param AssertLocationNotInGrid $assertLocationNotInGrid
	 * @param int $locationQtyToDelete
	 * @param Location[] $location
	 * @return void
	 */
	public function processAssert(
		LocationIndex $locationIndex,
		AssertLocationNotInGrid $assertLocationNotInGrid,
		$locationQtyToDelete,
		$location
	) {
		for ($i = 0; $i < $locationQtyToDelete; $i++) {
			$assertLocationNotInGrid->processAssert($location[$i], $locationIndex);
		}
	}

	/**
	 * Success message if Location not in grid
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Deleted locations are absent in Location grid.';
	}
}