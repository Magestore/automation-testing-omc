<?php
/**Form
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 14:25
 */
namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\BarcodeScan;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeScan\BarcodeScanIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertOpenScanBarcodeIsAvailable extends AbstractConstraint
{
    public function processAssert(BarcodeScanIndex $barcodeScanIndex, $idInput)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeScanIndex->getSearchBarcodeScanIndex()->inputIsVisible($idInput),
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
        return "Search for Scan is available";
    }
}