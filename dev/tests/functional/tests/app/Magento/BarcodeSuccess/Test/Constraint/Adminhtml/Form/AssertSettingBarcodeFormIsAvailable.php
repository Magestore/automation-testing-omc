<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 09:24
 */
namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\Form;


use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeSettingsIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertSettingBarcodeFormIsAvailable extends AbstractConstraint
{
    public function processAssert(BarcodeSettingsIndex $barcodeSettingsIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'Barcode Configuration',
            $barcodeSettingsIndex->getBlockSettingConfiguation()->getNameConfigurationBarcode(),
            'Page Left Barcode Configuration is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeSettingsIndex->getBlockSettingConfiguation()->isVisibleForm(),
            'Form config-edit-form is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $barcodeSettingsIndex->getBlockSettingConfiguation()->isFirstFieldFormVisible(),
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