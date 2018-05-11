<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 10/05/2018
 * Time: 11:17
 */

namespace Magento\Webpos\Test\Constraint\Zreport;

use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertGUIZreportStaffName
 * @package Magento\Webpos\Test\Constraint\Zreport
 */
class AssertGUIZreportStaffName extends \Magento\Mtf\Constraint\AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $staffName)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getStaffName()->isVisible(),
            'Zreport Pos Name not visible'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $staffName,
            $webposIndex->getSessionPrintShiftPopup()->getStaffName()->getText(),
            'Zreport Pos Name not visible'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'GUI Zreport error';
    }
}