<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 08/12/2017
 * Time: 08:16
 */
namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml\BarcodeListing\Form;
use Magento\Mtf\TestCase\Injectable;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeListing\BarcodeImportIndex;

class ImportBarcodeEntityTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var BarcodeImportIndex
     */
    protected $barcodeImportIndex;

    public function __inject(
        BarcodeImportIndex $barcodeImportIndex
    ) {
        $this->barcodeImportIndex = $barcodeImportIndex;
    }
    public function test(array $formFields=null)
    {
        $this->barcodeImportIndex->open();
        if($formFields != null)
            $this->barcodeImportIndex->getFormBarcodeImport()->fillNotFixture($formFields);
        $this->barcodeImportIndex->getPageActionsBlock()->save();
            sleep(2);

    }
}