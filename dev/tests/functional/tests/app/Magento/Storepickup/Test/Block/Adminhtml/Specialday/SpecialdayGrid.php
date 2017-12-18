<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/24/2017
 * Time: 4:06 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Specialday;

use Magento\Storepickup\Test\Block\Adminhtml\StorepickupGrid;

/**
 * Class SpecialdayGrid
 * @package Magento\Storepickup\Test\Block\Adminhtml\Specialday
 */
class SpecialdayGrid extends StorepickupGrid
{
    protected $filters = [
        'name' => ['selector' => '[name="specialday_name"]']
    ];
}