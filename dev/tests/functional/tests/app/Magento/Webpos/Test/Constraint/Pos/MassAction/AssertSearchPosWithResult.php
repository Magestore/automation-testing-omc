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

class AssertSearchPosWithResult extends AbstractConstraint
{

    public function processAssert(PosIndex $posIndex, Pos $pos)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $posIndex->getPosGrid()->isRowVisible([
                'pos_name' => $pos->getPosName()
            ]),
            'Pos ' . $pos->getPosName() . ' doesn\'t exist'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Pos is displayed';
    }
}