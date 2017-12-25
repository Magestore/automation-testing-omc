<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 14:22
 */
namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml\BarcodeScan;
use Magento\Mtf\TestCase\Injectable;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeScan\BarcodeScanIndex;

class CheckInputScanEntityForBarcodeTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var BarcodeScanIndex $barcodeScanIndex
     */
    protected $barcodeScanIndex;

    public function __inject(
        BarcodeScanIndex $barcodeScanIndex
    ) {
        $this->barcodeScanIndex = $barcodeScanIndex;
    }
    public function test()
    {
        $this->barcodeScanIndex->open();
        $this->barcodeScanIndex->getBarcodeGrid()->waitingForLoadingMaskPopUpNotVisible();
        $this->barcodeScanIndex->getBarcodeGrid()->waitingForLoadingMaskNotVisible();
    }
}