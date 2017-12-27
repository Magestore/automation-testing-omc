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

use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Mtf\Client\Element\SimpleElement;

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
        'entity_id[from]' => [
            'selector' => '.admin__data-grid-filters input[name="entity_id[from]"]',
        ],
        'entity_id[to]' => [
            'selector' => '.admin__data-grid-filters input[name="entity_id[to]"]',
        ],
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
        'closed_amount[to]' => [
            'selector' => '.admin__data-grid-filters input[name="closed_amount[to]"]',
        ],
        'cash_left[from]' => [
            'selector' => '.admin__data-grid-filters input[name="cash_left[from]"]',
        ],
        'cash_left[to]' => [
            'selector' => '.admin__data-grid-filters input[name="cash_left[to]"]',
        ],
        'shift_id' => [
            'selector' => '.admin__data-grid-filters input[name="shift_id"]',
        ],
        'staff_id' => [
            'selector' => '.admin__data-grid-filters input[name="staff_id"]',
            'input'    => 'Select',
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
}
