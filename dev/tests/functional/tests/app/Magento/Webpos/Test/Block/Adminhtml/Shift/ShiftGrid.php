<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-12 09:25:35
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-12 09:35:48
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Shift;

use Magento\Mtf\Client\Locator;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Mtf\Client\Element\SimpleElement;

/**
 * Class ShiftGrid
 * @package Magento\Webpos\Test\Block\Adminhtml\Shift
 */
class ShiftGrid extends DataGrid
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
        'opened_at[from]' => [
            'selector' => '.admin__data-grid-filters input[name="opened_at[from]"]',
        ],
        'opened_at[to]' => [
            'selector' => '.admin__data-grid-filters input[name="opened_at[to]"]',
        ],
        'closed_at[from]' => [
            'selector' => '.admin__data-grid-filters input[name="closed_at[from]"]',
        ],
        'closed_at[to]' => [
            'selector' => '.admin__data-grid-filters input[name="closed_at[to]"]',
        ],
        'float_amount[from]' => [
            'selector' => '.admin__data-grid-filters input[name="float_amount[from]"]',
        ],
        'float_amount[to]' => [
            'selector' => '.admin__data-grid-filters input[name="float_amount[to]"]',
        ],
        'closed_amount[from]' => [
            'selector' => '.admin__data-grid-filters input[name="closed_amount[from]"]',
        ],
        'closed_amount[to]' => [
            'selector' => '.admin__data-grid-filters input[name="closed_amount[to]"]',
        ]
    ];

    /**
     * Click on "Edit" link.
     *
     * @param SimpleElement $rowItem
     * @return void
     */
     protected function clickEditLink(SimpleElement $rowItem)
        {
            $rowItem->find($this->selectAction)->click();
        }
    /**
     * Fix core
     */
    public function resetFilter()
    {
        $this->waitLoader();
        parent::resetFilter();
    }

    public function getDataGridLastRow(){
        return $this->_rootElement->find('.//table//tbody//tr[@class="data-row"][last()]', Locator::SELECTOR_XPATH);
    }

    public function getPrintOfLastRow(){
        return $this->_rootElement->find('.//table//tbody//tr[@class="data-row"][last()]/td[@class="data-grid-actions-cell"]/a[@class="action-menu-item"]', Locator::SELECTOR_XPATH);
    }
}
