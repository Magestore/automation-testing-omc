<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/02/2018
 * Time: 10:20
 */

namespace Magento\Webpos\Test\TestCase\Role\EditRoleOnGrid;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class EditRoleOnGridTest extends Injectable
{
	/**
	 * Role Index page
	 *
	 * @var WebposRoleIndex
	 */
	protected $webposRoleIndex;

	/**
	 * Factory for fixture
	 *
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	/**
	 * @var WebposRole
	 */
	protected $role;

	/**
	 * @param FixtureFactory $fixtureFactory
	 * @param WebposRoleIndex $webposRoleIndex
	 */
	public function __inject(
		FixtureFactory $fixtureFactory,
		WebposRoleIndex $webposRoleIndex
	) {
		$this->fixtureFactory = $fixtureFactory;
		$this->webposRoleIndex = $webposRoleIndex;
	}

	public function test(
		WebposRole $initialRole,
		WebposRole $editRole,
		$action = ''
	)
	{
		$initialRole->persist();
		$this->role = $initialRole;

		$this->webposRoleIndex->open();
		$this->webposRoleIndex->getRoleGrid()->search([
			'role_id_from' => $initialRole->getRoleId(),
			'role_id_to' => $initialRole->getRoleId()
		]);
		$this->webposRoleIndex->getRoleGrid()->clickFirstRowToEdit();

		if ($action === 'cancel') {
			$this->webposRoleIndex->getRoleGrid()->getCancelButton()->click();
		} elseif ($action === 'save') {
			if (!empty($editRole->getDisplayName())) {
				$this->webposRoleIndex->getEditableRow()->getDisplayNameInput()->setValue($editRole->getDisplayName());
			}

			if (!empty($editRole->getDescription())) {
				$this->webposRoleIndex->getEditableRow()->getDescriptionInput()->setValue($editRole->getDescription());
			}

			$this->webposRoleIndex->getRoleGrid()->getSaveButton()->click();
		}

		return [
			'role' => $this->prepareRole($initialRole, $editRole)
		];

	}

	/**
	 * @param WebposRole $initialRole
	 * @param WebposRole $editRole
	 * @return \Magento\Mtf\Fixture\FixtureInterface
	 */
	public function prepareRole(WebposRole $initialRole, WebposRole $editRole)
	{
		$data = [
			'data' => array_merge(
				$initialRole->getData(),
				$editRole->getData()
			)
		];

		return $this->fixtureFactory->createByCode('webposRole', $data);
	}

	public function tearDown()
	{
		$this->webposRoleIndex->open();

		$this->webposRoleIndex->getRoleGrid()->massaction([['id' => $this->role->getRoleId()]],'Delete',true);
	}
}