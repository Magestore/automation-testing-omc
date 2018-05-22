<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 11/05/2018
 * Time: 10:18
 */

namespace Magento\Webpos\Test\Constraint\Zreport;

use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertXreportPaymentNotCashIn
 * @package Magento\Webpos\Test\Constraint\Zreport
 */
class AssertXreportPaymentNotCashIn extends \Magento\Mtf\Constraint\AbstractConstraint
{
    public function processAssert(
        WebposIndex $webposIndex,
        $totalSales,
        $expectedDrawer
    )
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat(0),
            $webposIndex->getSessionPrintShiftPopup()->getOpeningAmount()->getText(),
            'Xreport Opening amount not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($expectedDrawer),
            $webposIndex->getSessionPrintShiftPopup()->getExpectedDrawer()->getText(),
            'Xreport Expected Drawer not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat(0),
            $webposIndex->getSessionPrintShiftPopup()->getCashSales()->getText(),
            'Xreport cash sales not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat(0),
            $webposIndex->getSessionPrintShiftPopup()->getCashRefund()->getText(),
            'Xreport cash refund not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat(0),
            $webposIndex->getSessionPrintShiftPopup()->getPayIns()->getText(),
            'Xreport pay in not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat(0),
            $webposIndex->getSessionPrintShiftPopup()->getPayouts()->getText(),
            'Xreport pay out not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($totalSales),
            $webposIndex->getSessionPrintShiftPopup()->getTotalSales()->getText(),
            'Xreport total sales not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat(0),
            $webposIndex->getSessionPrintShiftPopup()->getDiscount()->getText(),
            'Xreport discount not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat(0),
            $webposIndex->getSessionPrintShiftPopup()->getRefund()->getText(),
            'Xreport refund not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($totalSales),
            $webposIndex->getSessionPrintShiftPopup()->getNetSales()->getText(),
            'Xreport net sales not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($totalSales),
            $webposIndex->getSessionPrintShiftPopup()->getPaymentAmount()->getText(),
            'Xreport payment cash in  not correct'
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

    /**
     * convert number to string at format price
     * @param $number
     * @return string
     */
    public function convertToPriceFormat($number)
    {
        $result = number_format(abs($number), 2, '.', '');
        $result = '$' . $result;
        if ($number < 0) {
            $result = '-' . $result;
        }
        return $result;
    }
}