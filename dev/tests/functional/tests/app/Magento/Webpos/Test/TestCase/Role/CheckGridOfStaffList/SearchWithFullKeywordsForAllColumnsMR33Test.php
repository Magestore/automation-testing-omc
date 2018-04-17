<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/28/2018
 * Time: 2:26 PM
 */

namespace Magento\Webpos\Test\TestCase\Role\CheckGridOfStaffList;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class SearchWithFullKeywordsForAllColumnsMR33Test extends Injectable
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
        $staffToSearch = $factory->createByCode('staff', ['dataset' => 'default']);
        $filters = [
            'staff_id_from' => $staffToSearch->getStaffId(),
            'staff_id_to' => $staffToSearch->getStaffId(),
            'username' => $staffToSearch->getUsername(),
            'user_display_name' => $staffToSearch->getDisplayName(),
            'email' => $staffToSearch->getEmail(),
            'status' => 'Enable'
        ];
        $staffGridBlock->search($filters);
        $this->assertTrue(
            $staffGridBlock->getEmptyText()->isVisible(),
            'Empty data message is not visible.'
        );
        $this->assertEquals(
            'We couldn\'t find any records.',
            $staffGridBlock->getEmptyText()->getText(),
            'Empty data message is wrong.'
        );
    }
}