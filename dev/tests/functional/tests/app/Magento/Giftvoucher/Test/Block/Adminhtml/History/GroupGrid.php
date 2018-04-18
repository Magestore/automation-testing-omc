<?php

namespace Magento\Giftvoucher\Test\Block\Adminhtml\History;

use Magento\Mtf\Client\Element\SimpleElement;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Mtf\Client\Locator;

/**
 * Backend Data Grid for Gifthistory Entity
 */
class GroupGrid extends DataGrid
{
    /**
     * Filters array mapping.
     *
     * @var array
     */
    protected $filters = [
        'history_id_from' => [
            'selector' => '[name="history_id[from]"]',
        ],
        'history_id_to' => [
            'selector' => '[name="history_id[to]"]',
        ],
        'created_at_from' => [
            'selector' => '[name="created_at[from]"]',
        ],
        'created_at_to' => [
            'selector' => '[name="created_at[to]"]',
        ],
        'action' => [
            'selector' => '[name="action"]',
            'input' => 'select',
        ],
        'amount_from' => [
            'selector' => '[name="amount[from]"]',
        ],
        'amount_to' => [
            'selector' => '[name="amount[to]"]',
        ],
        'order_increment_id' => [
            'selector' => '[name="order_increment_id"]',
        ],
        'status' => [
            'selector' => '[name="status"]',
            'input' => 'select',
        ],
        'extra_content' => [
            'selector' => '[name="extra_content"]',
        ],
        'comments' => [
            'selector' => '[name="comments"]',
        ],
    ];
}
