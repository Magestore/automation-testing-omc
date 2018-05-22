<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 08/12/2017
 * Time: 11:28
 */
namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml\BarcodeSettings\Form;
use Magento\Mtf\TestCase\Injectable;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeSettings\BarcodeSettingsIndex;
/**
 * Steps:
 * 1. LoginTest to the backend.
 * 2. Navigate to Inventory > BarcodeSetting.
 * 3. Fill in data according to data set.
 * 4. Save Setting.
 * 5. Perform appropriate assertions.
 *
 */
class SaveFormEntityForBarcodeTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var BarcodeSettingsIndex $barcodeSettingsIndex
     */
    protected $barcodeSettingsIndex;

    public function __inject(
        BarcodeSettingsIndex $barcodeSettingsIndex
    ) {
        $this->barcodeSettingsIndex = $barcodeSettingsIndex;
    }
    public function test($idGeneralSection, array $formFields=null)
    {
        $this->barcodeSettingsIndex->open();
        if (!$this->barcodeSettingsIndex->getBlockSettingConfiguation()->getGeneralSection($idGeneralSection)->isVisible()) {
            $this->barcodeSettingsIndex->getBlockSettingConfiguation()->openGeneralSection($idGeneralSection);
        }
        if($formFields != null)
            $this->barcodeSettingsIndex->getBlockSettingConfiguation()->fillNotFixture($formFields);
        $this->barcodeSettingsIndex->getPageActionsBlock()->save();

    }
}