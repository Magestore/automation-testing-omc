<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 08:25
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Role\Edit;


use Magento\Backend\Test\Block\Widget\FormTabs;

class WebposRoleForm extends FormTabs
{
	public function getDisplayNameError()
	{
		return $this->_rootElement->find('#page_display_name-error');
	}

	public function getRoleResources($arrs) {
	    if (is_array($arrs)) {
	        foreach ($arrs as $arr) {
                $this->_rootElement->find('li[data-id="'.$arr.'"] > a')->click();
            }
        } else {
            $this->_rootElement->find('li[data-id="'.$arrs.'"] > a')->click();
        }
    }

    public function assertSubRoleResources($arrs1, $arrs2) {
        if (is_array($arrs1)) {
            foreach ($arrs1 as $arr1) {
                \PHPUnit_Framework_Assert::assertTrue(
                    $this->_rootElement->find('li[data-id="'.$arr1.'"] > a')->isVisible(),
                    $arr1.' is not visible'
                );
                if (is_array($arrs2)) {
                    foreach ($arrs2 as $arr2) {
                        \PHPUnit_Framework_Assert::assertTrue(
                            $this->_rootElement->find('li[data-id="'.$arr1.'"]')->find('li[data-id="'.$arr2.'"] > a')->isVisible(),
                            $arr1.' '.$arr2.' is not visible'
                        );
                    }
                } else {
                    \PHPUnit_Framework_Assert::assertTrue(
                        $this->_rootElement->find('li[data-id="'.$arr1.'"]')->find('li[data-id="'.$arrs2.'"] > a')->isVisible(),
                    $arr1.' '.$arrs2.' is not visible'
                    );
                }
            }
        } else {
            \PHPUnit_Framework_Assert::assertTrue(
                $this->_rootElement->find('li[data-id="'.$arrs1.'"]')->isVisible(),
                $arrs1.' is not visible'
            );
            if (is_array($arrs2)) {
                foreach ($arrs2 as $arr2) {
                    \PHPUnit_Framework_Assert::assertTrue(
                        $this->_rootElement->find('li[data-id="'.$arrs1.'"]')->find('li[data-id="'.$arr2.'"] > a')->isVisible(),
                        $arrs1.' is not visible'
                    );
                }
            } else {
                \PHPUnit_Framework_Assert::assertTrue(
                    $this->_rootElement->find('li[data-id="'.$arrs1.'"]')->find('li[data-id="'.$arrs2.'"] > a')->isVisible(),
                    $arrs1.' '.$arrs2.' is not visible'
                );
            }
        }
    }
}