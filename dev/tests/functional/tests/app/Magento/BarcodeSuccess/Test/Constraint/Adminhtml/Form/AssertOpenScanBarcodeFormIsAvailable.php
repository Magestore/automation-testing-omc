<?php
/**Form
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 14:25
 */
namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\Form;


use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeScanIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertOpenScanBarcodeFormIsAvailable extends AbstractConstraint
{
    public function processAssert(BarcodeScanIndex $barcodeScanIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeScanIndex->getBlockSearchBarcodeScanIndex()->inputIsVisible(),
            'Block input scan search is not shown'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Import Form is available";
    }
}