<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 07:53
 */

namespace Magento\InventorySuccess\Test\Block\Adminhtml;


use Magento\Ui\Test\Block\Adminhtml\FormSections;

class FormSection extends FormSections
{
	protected $fieldSelector = '[name="%s"]';
	public function getField($name)
	{
		return $this->_rootElement->find(sprintf($this->fieldSelector, $name));
	}
}