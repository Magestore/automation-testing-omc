<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/27/2018
 * Time: 1:17 PM
 */

namespace Magento\Webpos\Test\TestCase\Role\CheckValidate;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class EnterValueGreater100MR24Test extends Injectable
{
    /**
     * @var WebposRoleIndex
     */
    protected $webposRoleIndex;

    /**
     * @var WebposRoleNew
     */
    protected $webposRoleNew;

    public function __inject(WebposRoleIndex $webposRoleIndex, WebposRoleNew $webposRoleNew)
    {
        $this->webposRoleIndex = $webposRoleIndex;
        $this->webposRoleNew = $webposRoleNew;
    }

    public function test(WebposRole $role)
    {
        $this->webposRoleIndex->open();
        $this->webposRoleIndex->getGridPageActions()->addNew();
        $this->webposRoleNew->getRoleForm()->fill($role);
        $this->webposRoleNew->getFormPageActions()->save();
    }
}