<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 03/11/2017
 * Time: 10:57
 */

namespace Magento\Webpos\Test\Block\Adminhtml\SystemConfig;


use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class MyBlock extends Block
{
	/**
	 * Default checkbox selector.
	 *
	 * @var string
	 */
	protected $defaultCheckbox = '#%s_%s_%s_inherit';

	public function setValueInheritCheckbox($tabName, $groupName, $fieldName, $value)
	{
		$checkbox = $this->_rootElement->find(
			sprintf($this->defaultCheckbox, $tabName, $groupName, $fieldName),
			Locator::SELECTOR_CSS,
			'checkbox'
		);
		$checkbox->setValue($value);
	}
}