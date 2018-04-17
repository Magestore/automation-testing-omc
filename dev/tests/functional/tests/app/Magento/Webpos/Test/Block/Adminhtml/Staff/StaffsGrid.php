<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-07 14:28:32
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-08 14:24:23
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Staff;

use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Mtf\Client\Element\SimpleElement;
use Magento\Mtf\Client\Locator;

class StaffsGrid extends DataGrid
{
    /**
     * Select action toggle.
     *
     * @var string
     */
    // protected $option = '[name="title"]';
    protected $selectAction = '.action-menu-item';

    /**
     * Filters array mapping.
     *
     * @var array
     */
    protected $filters = [
        'staff_id[from]' => [
            'selector' => '.admin__data-grid-filters input[name="staff_id[from]"]',
        ],
        'staff_id[to]' => [
            'selector' => '.admin__data-grid-filters input[name="staff_id[to]"]',
        ],
        'username' => [
            'selector' => '.admin__data-grid-filters input[name="username"]',
        ],
        'email' => [
            'selector' => '.admin__data-grid-filters input[name="email"]',
        ],
        'display_name' => [
            'selector' => '.admin__data-grid-filters input[name="display_name"]',
        ],
        'role_id' => [
            'selector' => '.admin__data-grid-filters input[name="role_id"]',
            'input' => 'select',
        ],
        'status' => [
            'selector' => '.admin__data-grid-filters input[name="status"]',
            'input' => 'select',
        ]

    ];

    public function waitLoader()
    {
        $this->waitForElementNotVisible($this->loader);
        $this->getTemplateBlock()->waitLoader();
    }

    /**
     * Click on "Edit" link.
     *
     * @param SimpleElement $rowItem
     * @return void
     */
    protected function clickEditLink(SimpleElement $rowItem)
    {
        $rowItem->find($this->selectAction)->click();
        // Neu nhu co 2 action. Vi du: delete va edit thi moi them lenh duoi day de lua chon.
        // $rowItem->find($this->editLink)->click();
    }

    /**
     * Fix core
     */
    public function resetFilter()
    {
        $this->waitLoader();
        parent::resetFilter();
    }

    public function getRowByEmail($email, $isStrict = true)
    {
        $rowTemplate = ($isStrict) ? $this->rowTemplateStrict : $this->rowTemplate;
        $rows = sprintf($rowTemplate, $email);
        $location = sprintf($this->rowPattern, $rows);
        return $this->_rootElement->find($location, Locator::SELECTOR_XPATH);
    }

    public function getActionButtonEditing($nameButton)
    {
        return $this->_rootElement->find('//tbody/tr/td/button[*[text()[normalize-space()="' . $nameButton . '"]]]', Locator::SELECTOR_XPATH);
    }

    public function setDisplayName($displayName)
    {
        $this->_rootElement->find('//tbody/tr/td/*/input[@name="display_name"]', Locator::SELECTOR_XPATH)->setValue($displayName);
    }

    public function setEmail($emailChange)
    {
        $this->_rootElement->find('//tbody/tr/td/*/input[@name="email"]', Locator::SELECTOR_XPATH)->setValue($emailChange);
    }

    public function getInputFieldEdtingByName($name)
    {
        return $this->_rootElement->find('//tbody/tr/td/*/input[@name="' . $name . '"]', Locator::SELECTOR_XPATH);
    }

    public function getFieldDisableEditingDisplay($text)
    {
        return $this->_rootElement->find('//tbody/tr/td[*[text()[normalize-space()="' . $text . '"]]]', Locator::SELECTOR_XPATH);
    }

    public function getMessageEditSuccess()
    {
        return $this->_rootElement->find('.data-grid-info-panel .message');
    }
}
