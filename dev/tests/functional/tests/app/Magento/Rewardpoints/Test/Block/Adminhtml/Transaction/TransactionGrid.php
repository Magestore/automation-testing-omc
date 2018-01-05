<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/24/2017
 * Time: 4:06 PM
 */

namespace Magento\Rewardpoints\Test\Block\Adminhtml\Transaction;

use Magento\Rewardpoints\Test\Block\Adminhtml\RewardGrid;

/**
 * Class TransactionGrid
 * @package Magento\Rewardpoints\Test\Block\Adminhtml\Transaction
 */
class TransactionGrid extends RewardGrid
{
    /**
     * Select action toggle.
     *
     * @var string
     */
    // protected $option = '[name="title"]';
    /**
     * @var string
     */
    protected $selectAction = '.action-menu-item';

    /**
     * Filters array mapping.
     *
     * @var array
     */
    protected $filters = [
        'transaction_id[from]' => [
            'selector' => '.admin__data-grid-filters input[name="transaction_id[from]"]',
        ],
        'transaction_id[to]' => [
            'selector' => '.admin__data-grid-filters input[name="transaction_id[to]"]',
        ],
        'point_amount[from]' => [
            'selector' => '.admin__data-grid-filters input[name="point_amount[from]"]',
        ],
        'point_amount[to]' => [
            'selector' => '.admin__data-grid-filters input[name="point_amount[to]"]',
        ],
        'point_used[from]' => [
            'selector' => '.admin__data-grid-filters input[name="point_used[from]"]',
        ],
        'point_used[to]' => [
            'selector' => '.admin__data-grid-filters input[name="point_used[to]"]',
        ],
        'created_time[from]' => [
            'selector' => '.admin__data-grid-filters input[name="created_time[from]"]',
        ],
        'created_time[to]' => [
            'selector' => '.admin__data-grid-filters input[name="created_time[to]"]',
        ],
        'expiration_date[from]' => [
            'selector' => '.admin__data-grid-filters input[name="expiration_date[from]"]',
        ],
        'expiration_date[to]' => [
            'selector' => '.admin__data-grid-filters input[name="created_time[to]"]',
        ],
        'title' => [
            'selector' => '.admin__data-grid-filters input[name="title"]',
        ],
        'customer_email' => [
            'selector' => '.admin__data-grid-filters input[name="customer_email"]',
        ],
        'action' => [
            'selector' => '.admin__data-grid-filters input[name="action"]',
            'input'    => 'select',
        ],
        'store_id' => [
            'selector' => '.admin__data-grid-filters input[name="store_id"]',
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