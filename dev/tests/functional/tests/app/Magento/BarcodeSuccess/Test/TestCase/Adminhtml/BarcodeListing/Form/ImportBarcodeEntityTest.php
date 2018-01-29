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
/**
 *
 * Steps:
 * 1. Open backend
 * 2. Go to  page BarcodeImport
 * 3. Perform Asserts for Form
 *
 */
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