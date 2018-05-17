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
            'Zreport Title not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getDrawerNumber()->isVisible(),
            'Zreport Drawer Number not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getPosName()->isVisible(),
            'Zreport Pos Name not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getStaffName()->isVisible(),
            'Zreport Staff name not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getOpened()->isVisible(),
            'Zreport opened time not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getOpeningAmount()->isVisible(),
            'Zreport Opening amount not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getExpectedDrawer()->isVisible(),
            'Zreport Expected Drawer amount not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getCashSales()->isVisible(),
            'Zreport cash sales not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getCashRefund()->isVisible(),
            'Zreport cash refund not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getPayIns()->isVisible(),
            'Zreport pay in not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getPayouts()->isVisible(),
            'Zreport pay out not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getTotalSales()->isVisible(),
            'Zreport total sales not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getDiscount()->isVisible(),
            'Zreport discount not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getRefund()->isVisible(),
            'Zreport refund not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getNetSales()->isVisible(),
            'Zreport net sales not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getPaymentAmount()->isVisible(),
            'Zreport payment cash in  not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionPrintShiftPopup()->getTimeToPrint()->isVisible(),
            'Zreport time to print not visible'
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