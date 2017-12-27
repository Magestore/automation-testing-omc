<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 4:31 PM
 */

namespace Magento\Storepickup\Test\Constraint\Specialday;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Fixture\StorepickupSpecialday;
use Magento\Storepickup\Test\Page\Adminhtml\SpecialdayIndex;

class AssertSpecialdayMassDeleteNotInGrid extends AbstractConstraint
{
    /**
     *
     * @param SpecialdayIndex $tagIndex
     * @param int $specialdaysQtyToDelete
     * @param StorepickupSpecialday[] $specialdays
     * @return void
     */
    public function processAssert(
        SpecialdayIndex $specialdayIndex,
        $specialdaysQtyToDelete,
        $specialdays
    ) {
        for ($i = 0; $i < $specialdaysQtyToDelete; $i++) {
            \PHPUnit_Framework_Assert::assertFalse(
                $specialdayIndex->getSpecialdayGrid()->isRowVisible(['name' => $specialdays[$i]->getSpecialdayName()]),
                'Specialday with name ' . $specialdays[$i]->getSpecialdayName() . 'is present in Specialday grid.'
            );
        }
    }

    /**
     * Success message if Specialday not in grid
     *
     * @return string
     */
    public function toString()
    {
        return 'Deleted Specialdays are absent in Specialdays grid.';
    }
}