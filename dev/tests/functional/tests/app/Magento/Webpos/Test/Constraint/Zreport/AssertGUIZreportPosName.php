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
 * Class AssertGUIZreportPosName
 * @package Magento\Webpos\Test\Constraint\Zreport
 */
class AssertGUIZreportPosName extends \Magento\Mtf\Constraint\AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $posName)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getPosName()->isVisible(),
            'Zreport Pos Name not visible'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $posName,
            $webposIndex->getSessionPrintShiftPopup()->getPosName()->getText(),
            'Zreport Pos Name not correct'
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