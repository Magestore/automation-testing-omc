<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/28/2018
 * Time: 2:01 PM
 */

namespace Magento\Webpos\Test\TestCase\Role\CheckGridOfStaffList;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class SearchWithFullKeywordsForAllColumnsMR32Test extends Injectable
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

    public function test(FixtureFactory $factory)
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
        /**
         * @var Staff $staffToSearch
         */
        $staffToSearch = $role->getDataFieldConfig('staff_id')['source']->getStaffs()[0];
        $filters = [
            'staff_id_from' => $staffToSearch->getStaffId(),
            'staff_id_to' => $staffToSearch->getStaffId(),
            'username' => $staffToSearch->getUsername(),
            'user_display_name' => $staffToSearch->getDisplayName(),
            'email' => $staffToSearch->getEmail(),
            'status' => 'Enable'
        ];
        $staffGridBlock->search($filters);
        $staffIdInGrid = $staffGridBlock->getFirstItemId();
        $this->assertEquals(
            $staffToSearch->getStaffId(),
            $staffIdInGrid,
            'Search result is wrong.'
        );
    }
}