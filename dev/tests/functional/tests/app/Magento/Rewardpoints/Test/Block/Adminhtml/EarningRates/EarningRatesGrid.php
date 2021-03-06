<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/24/2017
 * Time: 4:06 PM
 */

namespace Magento\Rewardpoints\Test\Block\Adminhtml\EarningRates;

use Magento\Rewardpoints\Test\Block\Adminhtml\RewardGrid;

/**
 * Class EarningRatesGrid
 * @package Magento\Rewardpoints\Test\Block\Adminhtml\EarningRates
 */
class EarningRatesGrid extends RewardGrid
{
    /**
     * Select action toggle.
     *
     * @var string
     */
    // protected $option = '[name="title"]';
    protected $selectAction = '.action-menu-item';
    protected $option = '[name="group"]';
    /**
     * Filters array mapping.
     *
     * @var array
     */
    protected $filters = [
        'rate_id[from]' => [
            'selector' => '.admin__data-grid-filters input[name="rate_id[from]"]',
        ],
        'rate_id[to]' => [
            'selector' => '.admin__data-grid-filters input[name="rate_id[to]"]',
        ],
        'points[from]' => [
            'selector' => '.admin__data-grid-filters input[name="points[from]"]',
        ],
        'points[to]' => [
            'selector' => '.admin__data-grid-filters input[name="points[to]"]',
        ],
        'money[from]' => [
            'selector' => '.admin__data-grid-filters input[name="money[from]"]',
        ],
        'money[to]' => [
            'selector' => '.admin__data-grid-filters input[name="money[to]"]',
        ],
        'sort_order[from]' => [
            'selector' => '.admin__data-grid-filters input[name="sort_order[from]"]',
        ],
        'sort_order[to]' => [
            'selector' => '.admin__data-grid-filters input[name="sort_order[to]"]',
        ],
        'website_ids' => [
            'selector' => '.admin__data-grid-filters input[name="website_ids"]',
            'input'    => 'select',
        ],
        'customer_group_ids' => [
            'selector' => '.admin__data-grid-filters input[name="customer_group_ids"]',
            'input'    => 'select',
        ],
        'status' => [
            'selector' => '[name="status"]',
            'input'    => 'select',
        ]
    ];

//    /**
//     * Click on "Edit" link.
//     *
//     * @param SimpleElement $rowItem
//     * @return void
//     */
//    protected function clickEditLink(SimpleElement $rowItem)
//    {
//        $rowItem->find($this->selectAction)->click();
//        $rowItem->find($this->editLink)->click();
//    }
    /**
     * Fix core
     */
    public function resetFilter()
    {
        $this->waitLoader();
        parent::resetFilter();
    }
}