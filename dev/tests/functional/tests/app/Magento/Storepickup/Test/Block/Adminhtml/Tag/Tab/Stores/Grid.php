<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/6/2017
 * Time: 5:36 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Tag\Tab\Stores;

use Magento\Backend\Test\Block\Widget\Grid as AbstractGrid;

class Grid extends AbstractGrid
{
    protected $filters = [
        'store_name' => [
            'selector' => 'input[name="store_name"]',
        ],
    ];

    protected $selectItem = '.col-checkbox_id input';
}