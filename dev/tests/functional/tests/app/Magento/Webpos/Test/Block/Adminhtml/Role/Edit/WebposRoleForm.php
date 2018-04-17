<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 08:25
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Role\Edit;


use Magento\Backend\Test\Block\Widget\FormTabs;

class WebposRoleForm extends FormTabs
{
	public function getDisplayNameError()
	{
		return $this->_rootElement->find('#page_display_name-error');
	}
}