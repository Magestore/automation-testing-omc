<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 07/09/2017
 * Time: 14:46
 */

namespace Magento\Webpos\Test\Constraint\Location;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

class AssertLocationMassDeleteInGrid extends AbstractConstraint
{
	/**
	 * Assert that location which haven't been deleted are present in Location grid
	 *
	 * @param LocationIndex $locationIndex
	 * @param AssertLocationInGrid $assertLocationInGrid
	 * @param int $locationQtyToDelete
	 * @param Location[] $location
	 * @return void
	 */
	public function processAssert(
		LocationIndex $locationIndex,
		AssertLocationInGrid $assertLocationInGrid,
		$locationQtyToDelete,
		$location
	) {
		$location = array_slice($location, $locationQtyToDelete);
		foreach ($location as $item) {
			$assertLocationInGrid->processAssert($item, $locationIndex);
		}
	}

	/**
	 * Text success exist Location in grid
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Location are present in Location grid.';
	}
}