<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 09:24
 */
namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\BarcodeSettings\Form;


use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeSettings\BarcodeSettingsIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertSettingBarcodeFormIsAvailable extends AbstractConstraint
{
    public function processAssert(BarcodeSettingsIndex $barcodeSettingsIndex, $idForm, $idFirstField, $pathNameConfiguration, $idGeneralSection)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'Barcode Configuration',
            $barcodeSettingsIndex->getBlockSettingConfiguation()->getNameConfigurationBarcode($pathNameConfiguration),
            'Page Left Barcode Configuration is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeSettingsIndex->getBlockSettingConfiguation()->isVisibleForm($idForm),
            'Form config-edit-form is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeSettingsIndex->getBlockSettingConfiguation()->isFirstFieldFormVisible($idFirstField),
            'First Field Form config-edit-form is not shown'
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