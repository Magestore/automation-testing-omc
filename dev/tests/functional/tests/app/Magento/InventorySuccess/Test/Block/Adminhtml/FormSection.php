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
	/**
	 * Magento form loader.
	 *
	 * @var string
	 */
	protected $spinner = '[data-role="spinner"]';

	protected $fieldSelector = '[name="%s"]';

	public function getField($name)
	{
		return $this->_rootElement->find(sprintf($this->fieldSelector, $name));
	}

	/**
	 * Wait page to load.
	 *
	 * @return void
	 */
	public function waitPageToLoad()
	{
		$this->waitForElementNotVisible($this->spinner);
	}
}