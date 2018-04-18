<?php

namespace Magento\Giftvoucher\Test\Block\Adminhtml\Pattern;

use Magento\Mtf\Client\Element\SimpleElement;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Mtf\Client\Locator;

/**
 * Backend Data Grid for Giftcode Pattern Entity
 */
class GroupGrid extends DataGrid
{
    /**
     * Filters array mapping.
     *
     * @var array
     */
    protected $filters = [
        'template_id_from' => [
            'selector' => '[name="template_id[from]"]',
        ],
        'template_id_to' => [
            'selector' => '[name="template_id[to]"]',
        ],
        'template_name' => [
            'selector' => '[name="template_name"]',
        ],
        'pattern' => [
            'selector' => '[name="pattern"]',
        ],
        'balance_from' => [
            'selector' => '[name="balance[from]"]',
        ],
        'balance_to' => [
            'selector' => '[name="balance[to]"]',
        ],
        'amount_from' => [
            'selector' => '[name="amount[from]"]',
        ],
        'amount_to' => [
            'selector' => '[name="amount[to]"]',
        ],
        'store_id' => [
            'selector' => '[name="store_id"]',
            'input' => 'selectstore'
        ],
    ];
}
