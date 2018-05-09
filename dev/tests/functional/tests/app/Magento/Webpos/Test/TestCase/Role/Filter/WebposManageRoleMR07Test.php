<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/9/18
 * Time: 11:23 AM
 */

namespace Magento\Webpos\Test\TestCase\Role\Filter;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

/**
 * Mange Role - Check FilterButton
 * //===================
 * MR07 - Check [Apply Filters] button with no results
 *
 * Precondition
 * Exist at least 2 records on the grid
 * 1. Go to backend > Sales > Manage Roles
 *
 * Steps
 * 1. Click on [Filters] button
 * 2. Input data into some fields that dont match any record
 * 3. Click on [Apply Filters] button
 *
 *  Acceptance
 * 1. Close Filter form
 * 2. Show message: "We couldn't find any records." on the Grid
 *
 * Class WebposManageRoleMR07Test
 * @package Magento\Webpos\Test\TestCase\Role\Filter
 */
class WebposManageRoleMR07Test extends Injectable
{
    protected $_roleIndex;

    public function __inject(WebposRoleIndex $roleIndex)
    {
        $this->_roleIndex = $roleIndex;
    }

    public function test($role)
    {
        $this->_roleIndex->open();
        $this->_roleIndex->getRoleGrid()->waitForGridLoader();
        $this->_roleIndex->getRoleGrid()->search([
            'display_name' => $role['name']
        ]);
        $this->_roleIndex->getRoleGrid()->waitForGridLoader();
    }
}