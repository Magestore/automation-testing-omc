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
 * Class AssertXreportPaymentsHasCashIn
 * @package Magento\Webpos\Test\Constraint\Zreport
 */
class AssertXreportPaymentsHasCashIn extends \Magento\Mtf\Constraint\AbstractConstraint
{
    public function processAssert(
        WebposIndex $webposIndex,
        $totalSales,
        $cashSales,
        $otherPaymentSales
    )
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat(0),
            $webposIndex->getSessionPrintShiftPopup()->getOpeningAmount()->getText(),
            'Xreport Opening amount not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($cashSales),
            $webposIndex->getSessionPrintShiftPopup()->getExpectedDrawer()->getText(),
            'Xreport Theoretical Closing amount not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($cashSales),
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
            $this->convertToPriceFormat($cashSales),
            $webposIndex->getSessionPrintShiftPopup()->getPaymentAmount(1)->getText(),
            'Xreport payment cash in  not correct'
        );
        if($otherPaymentSales){
            \PHPUnit_Framework_Assert::assertEquals(
                $this->convertToPriceFormat($otherPaymentSales),
                $webposIndex->getSessionPrintShiftPopup()->getPaymentAmount(2)->getText(),
                'Xreport other payment sale in  not correct'
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