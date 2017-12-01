<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 09:24
 */
namespace Magento\PurchaseOrderSuccess\Test\Constraint\Form;


use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SettingPurchaseManagementIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertSettingPurchaseManagementFormIsAvailable extends AbstractConstraint
{
    public function processAssert(SettingPurchaseManagementIndex $settingPurchaseManagementIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'Purchase Order Configuration',
            $settingPurchaseManagementIndex->getBlockSettingPurchaseManagementConfiguation()->getNameConfigurationBarcode(),
            'Page Left Purchase Order Configuration is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $settingPurchaseManagementIndex->getBlockSettingPurchaseManagementConfiguation()->isVisibleForm(),
            'Form config-edit-form is not shown'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $settingPurchaseManagementIndex->getBlockSettingPurchaseManagementConfiguation()->isFirstFieldFormVisible(),
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