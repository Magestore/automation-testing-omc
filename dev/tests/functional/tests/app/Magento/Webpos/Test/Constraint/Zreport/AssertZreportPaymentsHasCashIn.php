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
 * Class AssertZreportPaymentsHasCashIn
 * @package Magento\Webpos\Test\Constraint\Zreport
 */
class AssertZreportPaymentsHasCashIn extends \Magento\Mtf\Constraint\AbstractConstraint
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
            'Zreport Opening amount not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat(0),
            $webposIndex->getSessionPrintShiftPopup()->getClosingAmount()->getText(),
            'Zreport Closing amount not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($cashSales),
            $webposIndex->getSessionPrintShiftPopup()->getTheoreticalClosingAmount()->getText(),
            'Zreport Theoretical Closing amount not correct'
        );
        $difference = (-1) * $cashSales;
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($difference),
            $webposIndex->getSessionPrintShiftPopup()->getDifference()->getText(),
            'Zreport difference not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($cashSales),
            $webposIndex->getSessionPrintShiftPopup()->getCashSales()->getText(),
            'Zreport cash sales not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat(0),
            $webposIndex->getSessionPrintShiftPopup()->getCashRefund()->getText(),
            'Zreport cash refund not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat(0),
            $webposIndex->getSessionPrintShiftPopup()->getPayIns()->getText(),
            'Zreport pay in not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat(0),
            $webposIndex->getSessionPrintShiftPopup()->getPayouts()->getText(),
            'Zreport pay out not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($totalSales),
            $webposIndex->getSessionPrintShiftPopup()->getTotalSales()->getText(),
            'Zreport total sales not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat(0),
            $webposIndex->getSessionPrintShiftPopup()->getDiscount()->getText(),
            'Zreport discount not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat(0),
            $webposIndex->getSessionPrintShiftPopup()->getRefund()->getText(),
            'Zreport refund not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($totalSales),
            $webposIndex->getSessionPrintShiftPopup()->getNetSales()->getText(),
            'Zreport net sales not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($cashSales),
            $webposIndex->getSessionPrintShiftPopup()->getPaymentAmount(1)->getText(),
            'Zreport payment cash in  not correct'
        );
        if($otherPaymentSales){
            \PHPUnit_Framework_Assert::assertEquals(
                $this->convertToPriceFormat($otherPaymentSales),
                $webposIndex->getSessionPrintShiftPopup()->getPaymentAmount(2)->getText(),
                'Zreport other payment sale in  not correct'
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
        return 'GUI Zreport error';
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