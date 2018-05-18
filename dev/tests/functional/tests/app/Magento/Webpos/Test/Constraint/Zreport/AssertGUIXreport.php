<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 09/05/2018
 * Time: 15:26
 */

namespace Magento\Webpos\Test\Constraint\Zreport;

use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertGUIXreport
 * @package Magento\Webpos\Test\Constraint\Zreport
 */
class AssertGUIXreport extends \Magento\Mtf\Constraint\AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getXreportTitle()->isVisible(),
            'Xreport Title not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getDrawerNumber()->isVisible(),
            'Xreport Drawer Number not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getPosName()->isVisible(),
            'Xreport Pos Name not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getStaffName()->isVisible(),
            'Xreport Staff name not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getOpened()->isVisible(),
            'Xreport opened time not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getOpeningAmount()->isVisible(),
            'Xreport Opening amount not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getExpectedDrawer()->isVisible(),
            'Xreport Expected Drawer amount not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getCashSales()->isVisible(),
            'Xreport cash sales not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getCashRefund()->isVisible(),
            'Xreport cash refund not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getPayIns()->isVisible(),
            'Xreport pay in not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getPayouts()->isVisible(),
            'Xreport pay out not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getTotalSales()->isVisible(),
            'Xreport total sales not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getDiscount()->isVisible(),
            'Xreport discount not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getRefund()->isVisible(),
            'Xreport refund not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getNetSales()->isVisible(),
            'Xreport net sales not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getPaymentAmount()->isVisible(),
            'Xreport payment cash in  not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getTimeToPrint()->isVisible(),
            'Xreport time to print not visible'
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