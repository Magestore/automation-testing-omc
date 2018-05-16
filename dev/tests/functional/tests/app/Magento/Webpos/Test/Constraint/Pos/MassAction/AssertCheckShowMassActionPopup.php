<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/15/18
 * Time: 1:41 PM
 */

namespace Magento\Webpos\Test\Constraint\Pos\MassAction;

use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

class AssertCheckShowMassActionPopup extends \Magento\Mtf\Constraint\AbstractConstraint
{

    public function processAssert(PosIndex $posIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $posIndex->getModal()->getModalPopup()->isVisible(),
            'Popup modal is not show'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Popup shows correct';
    }
}