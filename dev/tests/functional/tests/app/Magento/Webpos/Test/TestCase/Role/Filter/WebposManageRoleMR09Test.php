<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/9/18
 * Time: 11:23 AM
 */

namespace Magento\Webpos\Test\TestCase\Role\Filter;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

/**
 * Mange Role - Check FilterButton
 * MR08 - Check [Apply Filters] button with full conditions
 *
 * Precondition
 * Exist at least 2 records on the grid
 * 1. Go to backend > Sales > Manage Roles
 *
 * Steps
 * 1. Click on [Filters] button
 * 2. Input data into all fields that match one or some records
 * 3. Click on [Apply Filters] button
 *
 *  Acceptance
 * 1. Close Filter form
 * 2. The records that matching condition will be shown on the grid
 *
 * Class WebposManageRoleMR08Test
 * @package Magento\Webpos\Test\TestCase\Role\Filter
 */
class WebposManageRoleMR09Test extends Injectable
{
    protected $_roleIndex;

    public function __inject(WebposRoleIndex $roleIndex)
    {
        $this->_roleIndex = $roleIndex;
    }

    public function test(WebposRole $role)
    {
        $role->persist();
        $this->_roleIndex->open();
        $this->_roleIndex->getRoleGrid()->waitForGridLoader();
        return [
            'webposRole' => $role,
            'fullCondition' => true
        ];
    }
}