<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/15/18
 * Time: 1:56 PM
 */

namespace Magento\Webpos\Test\Constraint\Pos\MassAction;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

class AssertSearchPosWithNoResult extends AbstractConstraint
{

    public function processAssert(PosIndex $posIndex, $filters)
    {
        foreach ($filters as $filter) {
            \PHPUnit_Framework_Assert::assertFalse(
                $posIndex->getPosGrid()->isRowVisible($filter),
                'Pos ' . $filter["pos_name"] . ' is displayed'
            );
        }

    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Some Poses don\'t display correct';
    }
}