<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 15/12/2017
 * Time: 08:36
 */
namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml\BarcodeListing\Grid;
use Magento\Mtf\TestCase\Injectable;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeListing\BarcodeGenerateIndex;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeListing\BarcodeIndex;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeListing\BarcodeHistoryIndex;

class MassActionEntityForBarcodeListingTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var BarcodeGenerateIndex
     */
    protected $barcodeGenerateIndex;
    /**
     * @var BarcodeIndex
     */
    protected $barcodeIndex;
    /**
     * @var BarcodeHistoryIndex
     */
    protected $barcodeHistoryIndex;

    public function __inject(
        BarcodeGenerateIndex $barcodeGenerateIndex,
        BarcodeIndex $barcodeIndex,
        BarcodeHistoryIndex $barcodeHistoryIndex

    ) {
        $this->barcodeGenerateIndex = $barcodeGenerateIndex;
        $this->barcodeIndex = $barcodeIndex;
        $this->barcodeHistoryIndex = $barcodeHistoryIndex;

    }
    public function test(array $products = null, $action, $fields)
    {
        //createBarcode
        $this->barcodeGenerateIndex->open();
        $this->barcodeGenerateIndex->getBarcodeGrid()->waitingForLoadingMaskFormNotVisible();
        $this->barcodeGenerateIndex->getFormBarcodeGenerate()->getSection('os_barcode_generate_form_general')->setFieldsData($fields);
        $this->barcodeGenerateIndex->getFormBarcodeGenerate()->getSection('os_generate_barcode')->setFieldsData($products);
        $this->barcodeGenerateIndex->getPageActionsBlock()->save();

//        $this->barcodeHistoryIndex->getHistoryGrid()->waitingForGridVisible();
//        $ids = $this->barcodeHistoryIndex->getHistoryGrid()->getAllIds();
//        $code = $this->barcodeHistoryIndex->getHistoryGrid()->getColumnValue($ids[0], 'Barcode');
//
//        $this->barcodeIndex->open();
//        $this->barcodeIndex->getBarcodeGrid()->searchAndSelect(['Barcode' => $code]);
//        $this->barcodeIndex->getBarcodeGrid()->selectAction($action);
//        sleep(3);

    }
}