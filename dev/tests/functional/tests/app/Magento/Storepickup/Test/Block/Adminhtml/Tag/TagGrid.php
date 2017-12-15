<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/24/2017
 * Time: 4:06 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Tag;

use Magento\Storepickup\Test\Block\Adminhtml\StorepickupGrid;

/**
 * Class TagGrid
 * @package Magento\Storepickup\Test\Block\Adminhtml\Tag
 */
class TagGrid extends StorepickupGrid
{
    protected $filters = [
        'id' => [
            'selector' => '[name="tag_id[]"]',
        ],
        'name' => [
            'selector' => '[name="tag_name"]',
        ],
        'description' => [
            'selector' => '[name="tag_description"]',
        ],
    ];
}