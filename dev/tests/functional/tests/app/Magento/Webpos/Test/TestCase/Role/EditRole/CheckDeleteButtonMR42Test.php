<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/28/2018
 * Time: 4:25 PM
 */

namespace Magento\Webpos\Test\TestCase\Role\EditRole;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class CheckDeleteButtonMR42Test extends Injectable
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
        $this->webposRoleNew->getFormPageActions()->delete();
        $this->assertTrue(
            $this->webposRoleNew->getModalBlock()->isVisible(),
            'Confirmation popup is not visible.'
        );
        $this->webposRoleNew->getModalBlock()->acceptAlert();

    }
}