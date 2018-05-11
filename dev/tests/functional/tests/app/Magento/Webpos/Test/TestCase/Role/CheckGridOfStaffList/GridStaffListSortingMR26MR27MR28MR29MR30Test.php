<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/28/2018
 * Time: 8:29 AM
 */

namespace Magento\Webpos\Test\TestCase\Role\CheckGridOfStaffList;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Setup\Exception;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class GridStaffListSortingMR26MR27MR28MR29MR30Test extends Injectable
{
    /**
     * @var WebposRoleIndex
     */
    protected $webposRoleIndex;

    /**
     * @var WebposRoleNew
     */
    protected $webposRoleNew;

    /**
     * @param WebposRoleIndex $webposRoleIndex
     * @param WebposRoleNew $webposRoleNew
     */
    public function __inject(WebposRoleIndex $webposRoleIndex, WebposRoleNew $webposRoleNew)
    {
        $this->webposRoleIndex = $webposRoleIndex;
        $this->webposRoleNew = $webposRoleNew;
    }

    public function test(FixtureFactory $factory, array $columnsForSorting)
    {
        /**
         * @var WebposRole $role
         */
        $role = $factory->createByCode('webposRole', ['dataset' => 'Role2Staff']);
        $role->persist();
        $this->webposRoleIndex->open();
        $this->webposRoleIndex->getRoleGrid()->searchAndOpen(['display_name' => $role->getDisplayName()]);
        $this->webposRoleNew->getRoleForm()->openTab('user_section');
        $staffGridBlock = $this->webposRoleNew->getRoleForm()->getTab('user_section')->getUserGrid();
//        $staffGridBlock->resetFilter();
        $sortingResults = [];
        foreach ($columnsForSorting as $columnName) {
            $staffGridBlock->sortByColumn($columnName);
            $sortingResults[$columnName]['firstIdAfterFirstSoring'] = $staffGridBlock->getFirstItemId();
            $staffGridBlock->sortByColumn($columnName);
            $sortingResults[$columnName]['firstIdAfterSecondSoring'] = $staffGridBlock->getFirstItemId();
        }

        return ['sortingResults' => $sortingResults];

    }
}