<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/8/2017
 * Time: 9:57 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Store\Edit\Tab\Tags;

use Magento\Backend\Test\Block\Widget\Grid as AbstractGrid;

class Grid extends AbstractGrid
{
    protected $filters = [
        'tag_name' => [
            'selector' => 'input[name="tag_name"]',
        ],
    ];

    protected $selectItem = '.col-checkbox_id input';
}