<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 08:07
 */

namespace Magento\Webpos\Test\TestCase\Role;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

/**
 * Class CreateWebposRoleEntityTest
 * @package Magento\Webpos\Test\TestCase\Role
 */
class CreateWebposRoleEntityTest extends Injectable
{
	protected $webposRoleIndex;

	protected $webposRoleNew;

	public function __inject(
		WebposRoleIndex $webposRoleIndex,
		WebposRoleNew $webposRoleNew
	)
	{
		$this->webposRoleIndex = $webposRoleIndex;
		$this->webposRoleNew = $webposRoleNew;
	}

	public function test(WebposRole $webposRole)
	{
		$this->webposRoleIndex->open();
		$this->webposRoleIndex->getPageActionsBlock()->addNew();
		$this->webposRoleNew->getRoleForm()->fill($webposRole);
		$this->webposRoleNew->getFormPageActions()->save();
	}
}