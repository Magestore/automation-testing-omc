<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 09:24
 */
namespace Magento\InventorySuccess\Test\Constraint\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\SettingInventoryIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertSettingInventoryFormIsAvailable extends AbstractConstraint
{
    public function processAssert(SettingInventoryIndex $settingInventoryIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'Inventory Management Configuration',
            $settingInventoryIndex->getBlockSettingConfiguation()->getNameConfigurationBarcode(),
            'Page Left Inventory Configuration is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $settingInventoryIndex->getBlockSettingConfiguation()->isVisibleForm(),
            'Form config-edit-form is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $settingInventoryIndex->getBlockSettingConfiguation()->isFirstFieldFormVisible(),
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