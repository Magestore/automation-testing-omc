<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 10/05/2018
 * Time: 16:30
 */

namespace Magento\Webpos\Test\Constraint\Zreport;

use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertGUIXreportPrintingTime
 * @package Magento\Webpos\Test\Constraint\Zreport
 */
class AssertGUIXreportPrintingTime extends \Magento\Mtf\Constraint\AbstractConstraint
{
    public function processAssert(
        WebposIndex $webposIndex
    )
    {
        $printingTime = date("l j F, Y g:i A");
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getTimeToPrint()->isVisible(),
            'Zreport Opened not visible'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $printingTime,
            $webposIndex->getSessionPrintShiftPopup()->getTimeToPrint()->getText(),
            'Zreport Opened String not correct'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'GUI Xreport error';
    }
}