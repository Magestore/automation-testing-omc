<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 15/12/2017
 * Time: 08:36
 */
namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml\BarcodeListing\Grid;
use Magento\Mtf\TestCase\Injectable;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeListing\BarcodeIndex;
use Magento\BarcodeSuccess\Test\Fixture\BarcodeGenerate;
/**
 *
 * Test Flow:
 * Preconditions:
 * 1. Create barcode
 *
 * Steps:
 * 1. Open backend
 * 2. Go to  page BarcodeListing grid
 * 3. Select template from preconditions
 * 4. Select in MassAction ("Print")
 * 5. Accept alert
 * 6. Perform all assertions according to dataset
 *
 */
class MassActionEntityForBarcodeListingTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */
    /**
     * @var BarcodeIndex
     */
    protected $barcodeIndex;
    public function __inject(
        BarcodeIndex $barcodeIndex
    ) {
        $this->barcodeIndex = $barcodeIndex;
    }
    public function test(BarcodeGenerate $barcodeGenerate)
    {
        $barcodeGenerate->persist();
        $this->barcodeIndex->open();
        $this->barcodeIndex->getBarcodeGrid()->massaction([], 'Print Barcode', false, 'Select All');
    }
}