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
 * Class AssertGUIZreportRefund
 * @package Magento\Webpos\Test\Constraint\Zreport
 */
class AssertGUIZreportRefund extends \Magento\Mtf\Constraint\AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $refund)
    {
        if($webposIndex->getSessionPrintShiftPopup()->getRefund()->isVisible())
        {
            \PHPUnit_Framework_Assert::assertEquals(
                $this->convertToPriceFormat($refund),
                $webposIndex->getSessionPrintShiftPopup()->getRefund()->getText(),
                'Zreport Refund not correct'
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