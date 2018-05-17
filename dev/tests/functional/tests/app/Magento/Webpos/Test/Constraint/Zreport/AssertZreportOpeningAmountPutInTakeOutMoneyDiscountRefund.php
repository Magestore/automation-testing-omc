<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 14/05/2018
 * Time: 08:58
 */

namespace Magento\Webpos\Test\Constraint\Zreport;

use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertZreportOpeningAmountPutInTakeOutMoneyDiscountRefund
 * @package Magento\Webpos\Test\Constraint\Zreport
 */
class AssertZreportOpeningAmountPutInTakeOutMoneyDiscountRefund extends \Magento\Mtf\Constraint\AbstractConstraint
{
    public function processAssert(
        WebposIndex $webposIndex,
        $openingAmount,
        $closingAmount,
        $cashSales,
        $cashRefund,
        $payOut,
        $payIn,
        $totalSales,
        $otherPaymentSales = null,
        $discountAmount,
        $refund
    )
    {
        \PHPUnit_Framework_Assert::assertEquals(
            self::convertToPriceFormat($openingAmount),
            $webposIndex->getSessionPrintShiftPopup()->getOpeningAmount()->getText(),
            'Zreport Opening amount not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            self::convertToPriceFormat($closingAmount),
            $webposIndex->getSessionPrintShiftPopup()->getClosingAmount()->getText(),
            'Zreport Closing amount not correct'
        );
        $theoreticalClosingAmount = $cashSales - $cashRefund - $payOut + $payIn + $openingAmount;
        \PHPUnit_Framework_Assert::assertEquals(
            self::convertToPriceFormat($theoreticalClosingAmount),
            $webposIndex->getSessionPrintShiftPopup()->getTheoreticalClosingAmount()->getText(),
            'Zreport Theoretical Closing amount not correct'
        );
        $difference = $closingAmount - $theoreticalClosingAmount;
        \PHPUnit_Framework_Assert::assertEquals(
            self::convertToPriceFormat($difference),
            $webposIndex->getSessionPrintShiftPopup()->getDifference()->getText(),
            'Zreport difference not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            self::convertToPriceFormat($cashSales),
            $webposIndex->getSessionPrintShiftPopup()->getCashSales()->getText(),
            'Zreport cash sales not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($cashRefund),
            $webposIndex->getSessionPrintShiftPopup()->getCashRefund()->getText(),
            'Zreport cash refund not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($payIn),
            $webposIndex->getSessionPrintShiftPopup()->getPayIns()->getText(),
            'Zreport pay in not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($payOut * (-1)),
            $webposIndex->getSessionPrintShiftPopup()->getPayouts()->getText(),
            'Zreport pay out not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($totalSales),
            $webposIndex->getSessionPrintShiftPopup()->getTotalSales()->getText(),
            'Zreport total sales not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($discountAmount * (-1)),
            $webposIndex->getSessionPrintShiftPopup()->getDiscount()->getText(),
            'Zreport discount not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat((-1) * $refund),
            $webposIndex->getSessionPrintShiftPopup()->getRefund()->getText(),
            'Zreport refund not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($totalSales - $refund),
            $webposIndex->getSessionPrintShiftPopup()->getNetSales()->getText(),
            'Zreport net sales not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($cashSales),
            $webposIndex->getSessionPrintShiftPopup()->getPaymentAmount(1)->getText(),
            'Zreport payment cash in  not correct'
        );
        if ($otherPaymentSales) {
            \PHPUnit_Framework_Assert::assertEquals(
                $this->convertToPriceFormat($otherPaymentSales),
                $webposIndex->getSessionPrintShiftPopup()->getPaymentAmount(2)->getText(),
                'Zreport other payment sale in  not correct'
            );
        }
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