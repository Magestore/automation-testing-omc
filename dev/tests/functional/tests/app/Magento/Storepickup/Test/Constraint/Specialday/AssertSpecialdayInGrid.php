<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/18/2017
 * Time: 3:05 PM
 */

namespace Magento\Storepickup\Test\Constraint\Specialday;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Fixture\StorepickupSpecialday;
use Magento\Storepickup\Test\Page\Adminhtml\SpecialdayIndex;

class AssertSpecialdayInGrid extends AbstractConstraint
{
    /**
     * Filters array mapping.
     *
     * @var array
     */
    private $filter;

    public function processAssert(
        StorepickupSpecialday $storepickupSpecialday,
        SpecialdayIndex $specialdayIndex
    ) {
        $specialdayIndex->open();
        $data = $storepickupSpecialday->getData();
        $this->filter = ['name' => $data['specialday_name']];
        $specialdayIndex->getSpecialdayGrid()->search($this->filter);

        \PHPUnit_Framework_Assert::assertTrue(
            $specialdayIndex->getSpecialdayGrid()->isRowVisible($this->filter, false, false),
            'Specialday is absent in Specialday grid'
        );

//        \PHPUnit_Framework_Assert::assertEquals(
//            count($specialdayIndex->getSpecialdayGrid()->getAllIds()),
//            1,
//            'There is more than one special day founded'
//        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Specialday is present in grid.';
    }
}