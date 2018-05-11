<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/02/2018
 * Time: 09:29
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Role;


use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class EditableRow extends Block
{
	public function getCheckbox()
	{
		return $this->_rootElement->find('.admin__control-checkbox', Locator::SELECTOR_CSS, 'checkbox');
	}

	public function getDisplayNameInput()
	{
		return $this->_rootElement->find('input[name="display_name"]');
	}

	public function getDescriptionInput()
	{
		return $this->_rootElement->find('input[name="description"]');
	}
}