<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 4:35 PM
 */

namespace Magento\Storepickup\Test\Constraint\Specialday;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Fixture\StorepickupSpecialday;
use Magento\Storepickup\Test\Page\Adminhtml\SpecialdayIndex;

class AssertSpecialdayMassDeleteInGrid extends AbstractConstraint
{
    /**
     *
     * @param SpecialdayIndex $specialdayIndex
     * @param  AssertSpecialdayInGrid $assertSpecialdayInGrid
     * @param int $specialdaysQtyToDelete
     * @param StorepickupSpecialday[] $specialdays
     * @return void
     */
    public function processAssert(
        SpecialdayIndex $specialdayIndex,
        AssertSpecialdayInGrid $assertSpecialdayInGrid,
        $specialdaysQtyToDelete,
        $specialdays
    ) {
        $specialdays = array_slice($specialdays, $specialdaysQtyToDelete);
        foreach ($specialdays as $specialday) {
            $assertSpecialdayInGrid->processAssert($specialday, $specialdayIndex);
        }
    }

    /**
     * Success message if Specialday in grid
     *
     * @return string
     */
    public function toString()
    {
        return 'Specialdays are present in Specialday grid.';
    }
}