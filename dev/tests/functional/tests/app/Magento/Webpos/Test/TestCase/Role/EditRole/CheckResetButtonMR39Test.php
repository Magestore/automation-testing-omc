<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/28/2018
 * Time: 3:41 PM
 */

namespace Magento\Webpos\Test\TestCase\Role\EditRole;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class CheckResetButtonMR39Test extends Injectable
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

    public function test(FixtureFactory $factory, WebposRole $roleEdit)
    {
        /**
         * @var WebposRole $role
         */
        $role = $factory->createByCode('webposRole', ['dataset' => 'Role2Staff']);
        $role->persist();
        $this->webposRoleIndex->open();
        $this->webposRoleIndex->getRoleGrid()->searchAndOpen(['display_name' => $role->getDisplayName()]);
        $this->webposRoleNew->getRoleForm()->fill($roleEdit);
        $this->webposRoleNew->getFormPageActions()->reset();
        $fieldsData = $this->webposRoleNew->getRoleForm()->getTab('general')->getFieldsData();
        $roleData = $role->getData();
        foreach ($fieldsData as $key => $value) {
            $this->assertEquals(
                $roleData[$key],
                $value,
                $key . ' is not reset.'
            );
        }
    }
}