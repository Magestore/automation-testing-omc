<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 09:31
 */

namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml\BarcodeSettings;
use Magento\Mtf\TestCase\Injectable;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeSettings\BarcodeSettingsIndex;

class CheckSettingEntityForBarcodeTest extends Injectable
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
    public function test($idGeneralSection)
    {
        $this->barcodeSettingsIndex->open();
	    if (!$this->barcodeSettingsIndex->getBlockSettingConfiguation()->getGeneralSection($idGeneralSection)->isVisible()) {
		    $this->barcodeSettingsIndex->getBlockSettingConfiguation()->openGeneralSection($idGeneralSection);
	    }
    }
}