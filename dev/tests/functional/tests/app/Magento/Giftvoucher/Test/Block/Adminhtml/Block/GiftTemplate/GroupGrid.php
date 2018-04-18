<?php

namespace Magento\Giftvoucher\Test\Block\Adminhtml\Block\GiftTemplate;

use Magento\Mtf\Client\Element\SimpleElement;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;

/**
 * Backend Data Grid for Giftcode Entity
 */
class GroupGrid extends DataGrid
{

    /**
     * Filters array mapping.
     *
     * @var array
     */
    protected $filters = [
        'giftcard_template_id_from' => [
            'selector' => '[name="giftcard_template_id[from]"]',
        ],       
        'giftcard_template_id_to' => [
            'selector' => '[name="giftcard_template_id[to]"]',
        ],         
        'template_name' => [
            'selector' => '[name="template_name"]',
        ],
        'status' => [
            'selector' => '//label[span[text()="Status"]]/following-sibling::div',
            'strategy' => 'xpath',
            'input' => 'dropdownmultiselect',
        ],
        'updated_at_from' => [
            'selector' => '[name="updated_at[from]"]',
        ],
        'updated_at_to' => [
            'selector' => '[name="updated_at[to]"]',
        ],
    ];

    
    /**
     * Locator value for select perpage element
     * 
     * @var string
     */
    protected $perPage = '.admin__data-grid-pager-wrap .selectmenu';
    
}
