<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/11/2017
 * Time: 16:04
 */

namespace Magento\InventorySuccess\Test\Block\Adminhtml\SendStock\Edit;



use Magento\Ui\Test\Block\Adminhtml\FormSections;

class SendStockForm extends FormSections
{
	protected $fieldSelector = '[name="%s"]';
	public function getField($name)
	{
		return $this->_rootElement->find(sprintf($this->fieldSelector, $name));
	}
}