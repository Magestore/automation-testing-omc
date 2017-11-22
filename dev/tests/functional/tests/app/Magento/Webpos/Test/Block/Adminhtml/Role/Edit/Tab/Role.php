<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 08:50
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Role\Edit\Tab;

use Magento\Backend\Test\Block\Widget\Tab;
use Magento\Mtf\Client\Element\SimpleElement;

class Role extends Tab
{
	/**
	 * Fills username in user grid
	 *
	 * @param array $fields
	 * @param SimpleElement $element
	 * @return void
	 */
	public function setFieldsData(array $fields, SimpleElement $element = null)
	{
		$users = (is_array($fields['role_staff']['value']))
			? $fields['role_staff']['value']
			: [$fields['role_staff']['value']];
		foreach ($users as $user) {
			$this->getUserGrid()->searchAndSelect(['staff_id_from' => $user, 'staff_id_to' => $user]);
		}
	}

	/**
	 * @return \Magento\Mtf\Block\BlockInterface
	 */
	public function getUserGrid()
	{
		return $this->blockFactory->create(
			'Magento\Webpos\Test\Block\Adminhtml\Role\Edit\Tab\User\Grid',
			['element' => $this->_rootElement->find('#staff_grid')]
		);
	}
}