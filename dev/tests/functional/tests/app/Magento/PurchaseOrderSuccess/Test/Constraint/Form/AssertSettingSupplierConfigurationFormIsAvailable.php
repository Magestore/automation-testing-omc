<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 10:40
 */
namespace Magento\PurchaseOrderSuccess\Test\Constraint\Form;


use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SettingSupplierConfigurationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertSettingSupplierConfigurationFormIsAvailable extends AbstractConstraint
{
    public function processAssert(SettingSupplierConfigurationIndex $settingSupplierConfigurationIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'Supplier Configuration',
            $settingSupplierConfigurationIndex->getBlockSettingSupplierConfiguration()->getNameConfigurationBarcode(),
            'Page Left Supplier Configuration is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $settingSupplierConfigurationIndex->getBlockSettingSupplierConfiguration()->isVisibleForm(),
            'Form config-edit-form is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $settingSupplierConfigurationIndex->getBlockSettingSupplierConfiguration()->isFirstFieldFormVisible(),
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