<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-07 08:57:00
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-06 09:42:58
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Locations;

use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Mtf\Client\Element\SimpleElement;

class LocationsGrid  extends DataGrid
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
        'location_id[from]' => [
            'selector' => '.admin__data-grid-filters input[name="location_id[from]"]',
        ],
        'location_id[to]' => [
            'selector' => '.admin__data-grid-filters input[name="location_id[to]"]',
        ],
        'description' => [
            'selector' => '.admin__data-grid-filters input[name="description"]',
        ],
        'address' => [
            'selector' => '.admin__data-grid-filters input[name="address"]',
        ],
        'display_name' => [
            'selector' => '.admin__data-grid-filters input[name="display_name"]',
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
}
