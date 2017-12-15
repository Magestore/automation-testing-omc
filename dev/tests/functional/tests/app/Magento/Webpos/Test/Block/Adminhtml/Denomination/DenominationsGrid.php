<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/5/2017
 * Time: 9:11 AM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Denomination;

use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Mtf\Client\Element\SimpleElement;

/**
 * Class DenominationGrid
 * @package Magento\Webpos\Test\Block\Adminhtml\Denomination
 */
class DenominationsGrid extends DataGrid
{
    /**
     * @var string
     */
    protected $selectAction = '.action-menu-item';

    /**
     * @var array
     */
    protected $filters = [
        'denomination_id[from]' => [
            'selector' => '.admin__data-grid-filters input[name="denomination_id[from]"]',
        ],
        'denomination_id[to]' => [
            'selector' => '.admin__data-grid-filters input[name="denomination_id[to]"]',
        ],
        'denomination_name' => [
            'selector' => '.admin__data-grid-filters input[name="denomination_name"]',
        ],
        'denomination_value' => [
            'selector' => '.admin__data-grid-filters input[name="denomination_value"]',
        ],
        'sort_order' => [
            'selector' => '.admin__data-grid-filters input[name="sort_order"]',
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
}