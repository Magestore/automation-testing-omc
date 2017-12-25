<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-08 10:59:55
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-08 13:27:02
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Pos;

use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Mtf\Client\Element\SimpleElement;

class PosGrid  extends DataGrid
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
        'pos_id[from]' => [
            'selector' => '.admin__data-grid-filters input[name="pos_id[from]"]',
        ],
        'pos_id[to]' => [
            'selector' => '.admin__data-grid-filters input[name="pos_id[to]"]',
        ],
        'pos_name' => [
            'selector' => '.admin__data-grid-filters input[name="pos_name"]',
        ],
        'location_id' => [
            'selector' => '.admin__data-grid-filters input[name="location_id"]',
            'input'    => 'Select',
        ],
        'store_id' => [
            'selector' => '.admin__data-grid-filters input[name="store_id"]',
            'input'    => 'Multiselect',
        ],
        'staff_id' => [
            'selector' => '.admin__data-grid-filters input[name="staff_id"]',
            'input'    => 'Select',
        ],
        'status' => [
            'selector' => '.admin__data-grid-filters input[name="status"]',
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
