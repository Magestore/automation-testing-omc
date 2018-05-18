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
 * Class AssertXreportOpeningAmountPutInTakeOutMoneyDiscountRefund
 * @package Magento\Webpos\Test\Constraint\Zreport
 */
class AssertXreportOpeningAmountPutInTakeOutMoneyDiscountRefund extends \Magento\Mtf\Constraint\AbstractConstraint
{
    public function processAssert(
        WebposIndex $webposIndex,
        $openingAmount,
        $cashSales,
        $cashRefund,
        $payOut,
        $payIn,
        $totalSales,
        $otherPaymentSales = null,
        $discountAmount,
        $refund,
        $symbol = '$'
    )
    {
        \PHPUnit_Framework_Assert::assertEquals(
            self::convertToPriceFormat($openingAmount, $symbol),
            $webposIndex->getSessionPrintShiftPopup()->getOpeningAmount()->getText(),
            'Zreport Opening amount not correct'
        );
        $expectedDrawer = $cashSales - $cashRefund - $payOut + $payIn + $openingAmount;
        \PHPUnit_Framework_Assert::assertEquals(
            self::convertToPriceFormat($expectedDrawer, $symbol),
            $webposIndex->getSessionPrintShiftPopup()->getExpectedDrawer()->getText(),
            'Zreport Expected Drawer not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            self::convertToPriceFormat($cashSales, $symbol),
            $webposIndex->getSessionPrintShiftPopup()->getCashSales()->getText(),
            'Zreport cash sales not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($cashRefund, $symbol),
            $webposIndex->getSessionPrintShiftPopup()->getCashRefund()->getText(),
            'Zreport cash refund not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($payIn, $symbol),
            $webposIndex->getSessionPrintShiftPopup()->getPayIns()->getText(),
            'Zreport pay in not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($payOut * (-1), $symbol),
            $webposIndex->getSessionPrintShiftPopup()->getPayouts()->getText(),
            'Zreport pay out not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($totalSales, $symbol),
            $webposIndex->getSessionPrintShiftPopup()->getTotalSales()->getText(),
            'Zreport total sales not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($discountAmount * (-1), $symbol),
            $webposIndex->getSessionPrintShiftPopup()->getDiscount()->getText(),
            'Zreport discount not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat((-1) * $refund, $symbol),
            $webposIndex->getSessionPrintShiftPopup()->getRefund()->getText(),
            'Zreport refund not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($totalSales - $refund, $symbol),
            $webposIndex->getSessionPrintShiftPopup()->getNetSales()->getText(),
            'Zreport net sales not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $this->convertToPriceFormat($cashSales, $symbol),
            $webposIndex->getSessionPrintShiftPopup()->getPaymentAmount(1)->getText(),
            'Zreport payment cash in  not correct'
        );
        if ($otherPaymentSales) {
            \PHPUnit_Framework_Assert::assertEquals(
                $this->convertToPriceFormat($otherPaymentSales, $symbol),
                $webposIndex->getSessionPrintShiftPopup()->getPaymentAmount(2)->getText(),
                'Zreport other payment sale in  not correct'
            );
        }
    }

    /**
     * convert number to string at format price
     * @param $number
     * @param $symbol
     * @return string
     */
    public function convertToPriceFormat($number, $symbol = '$')
    {
        $result = number_format(abs($number), 2, '.', '');
        $result = $symbol . $result;
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