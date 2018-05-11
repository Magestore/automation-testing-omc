<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/9/18
 * Time: 10:10 AM
 */

namespace Magento\Webpos\Test\TestCase\Role\Filter;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Role\Filter\AssertManageRoleFilterBlock;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

/**
 * Mange Role - Check FilterButton
 * MR06 - Check [Cancel] button
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Roles
 *
 * Steps
 * 1. Click on [Filters] button
 * 2. Click on [Cancel] button
 *
 *  Acceptance
 * 1. Open Filters form including:
 * - Fileds: ID, Display name, Description
 *- Buttons: Cancel, Apply Filters
 * 2. Close Filters form
 *
 * Class WebposManageRoleMR06Test
 * @package Magento\Webpos\Test\TestCase\Role\Filter
 */
class WebposManageRoleMR06Test extends Injectable
{
    /**
     * Role index Page
     *
     * @var $_roleIndex
     */
    protected $_roleIndex;

    public function __inject(WebposRoleIndex $roleIndex)
    {
        $this->_roleIndex = $roleIndex;
    }

    public function test(AssertManageRoleFilterBlock $assertManageRoleFilterBlock, $fields)
    {
        $this->_roleIndex->open();
        $this->_roleIndex->getRoleGrid()->waitForGridLoader();
        $this->_roleIndex->getRoleGrid()->getFilterButton()->click();
        $assertManageRoleFilterBlock->processAssert($this->_roleIndex, $fields);
        $this->_roleIndex->getRoleGrid()->getFilterCancelButton()->click();
        sleep(1);
    }
}