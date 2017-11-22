<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 14:32
 */

namespace Magento\Webpos\Test\TestCase\Role;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Block\Webpos;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class DeleteWebposRoleEntityTest extends Injectable
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
		// Precondition
		$webposRole->persist();

		$data = ($webposRole->getData());

		$name = $data['display_name'];

		//Steps
		$this->webposRoleIndex->open();
		$this->webposRoleIndex->getRoleGrid()->searchAndOpen(['display_name' => $name]);
		$this->webposRoleNew->getFormPageActions()->delete();
		$this->webposRoleNew->getModalBlock()->acceptAlert();
	}
}