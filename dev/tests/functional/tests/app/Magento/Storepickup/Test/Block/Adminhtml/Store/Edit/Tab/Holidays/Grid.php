<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/8/2017
 * Time: 10:17 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Store\Edit\Tab\Holidays;

use Magento\Backend\Test\Block\Widget\Grid as AbstractGrid;

class Grid extends AbstractGrid
{
    protected $filters = [
        'holiday_name' => [
            'selector' => 'input[name="holiday_name"]',
        ],
    ];

    protected $selectItem = '.col-checkbox_id input';
}