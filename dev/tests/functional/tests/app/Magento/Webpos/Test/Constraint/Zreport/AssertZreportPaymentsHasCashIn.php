<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 11/05/2018
 * Time: 10:18
 */

namespace Magento\Webpos\Test\Constraint\Zreport;


use Magento\Webpos\Test\Page\WebposIndex;

class AssertZreportPaymentsHasCashIn extends \Magento\Mtf\Constraint\AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $totalSales, $cashSales = '$0.00', $otherPaymentSales)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            '$0.00',
            $webposIndex->getSessionPrintShiftPopup()->getOpeningAmount()->getText(),
            'Zreport Opening amount not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            '$0.00',
            $webposIndex->getSessionPrintShiftPopup()->getClosingAmount()->getText(),
            'Zreport Closing amount not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $cashSales,
            $webposIndex->getSessionPrintShiftPopup()->getTheoreticalClosingAmount()->getText(),
            'Zreport Theoretical Closing amount not correct'
        );
        $difference = $cashSales;
        if ($difference !== '$0.00')
        {
            $difference = '-' . $difference;
        }
        \PHPUnit_Framework_Assert::assertEquals(
            $difference,
            $webposIndex->getSessionPrintShiftPopup()->getDifference()->getText(),
            'Zreport difference not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $cashSales,
            $webposIndex->getSessionPrintShiftPopup()->getCashSales()->getText(),
            'Zreport cash sales not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            '$0.00',
            $webposIndex->getSessionPrintShiftPopup()->getCashRefund()->getText(),
            'Zreport cash refund not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            '$0.00',
            $webposIndex->getSessionPrintShiftPopup()->getPayIns()->getText(),
            'Zreport pay in not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            '$0.00',
            $webposIndex->getSessionPrintShiftPopup()->getPayouts()->getText(),
            'Zreport pay out not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $totalSales,
            $webposIndex->getSessionPrintShiftPopup()->getTotalSales()->getText(),
            'Zreport total sales not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            '$0.00',
            $webposIndex->getSessionPrintShiftPopup()->getDiscount()->getText(),
            'Zreport discount not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            '$0.00',
            $webposIndex->getSessionPrintShiftPopup()->getRefund()->getText(),
            'Zreport refund not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $totalSales,
            $webposIndex->getSessionPrintShiftPopup()->getNetSales()->getText(),
            'Zreport net sales not correct'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $cashSales,
            $webposIndex->getSessionPrintShiftPopup()->getPaymentAmount(1)->getText(),
            'Zreport payment cash in  not correct'
        );
        if($otherPaymentSales){
            \PHPUnit_Framework_Assert::assertEquals(
                $otherPaymentSales,
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
}