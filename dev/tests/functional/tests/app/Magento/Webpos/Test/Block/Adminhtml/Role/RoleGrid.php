<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 08:20
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Role;


use Magento\Mtf\Client\Element\SimpleElement;
use Magento\Mtf\Client\Locator;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;

class RoleGrid extends DataGrid
{
	/**
	 * Filters array mapping.
	 *
	 * @var array
	 */
	protected $filters = [
		'role_id_from' => [
			'selector' => '[name="role_id[from]"]',
		],
		'role_id_to' => [
			'selector' => '[name="role_id[to]"]',
		],
		'display_name' => [
			'selector' => '[name="display_name"]',
		],
		'description' => [
			'selector' => '[name="description"]',
		]
	];

	/**
	 * Click on "Edit" link.
	 *
	 * @param SimpleElement $rowItem
	 * @return void
	 */
	protected function clickEditLink(SimpleElement $rowItem)
	{
		$rowItem->find($this->editLink)->click();
	}
    /**
     * Fix core
     */
    public function resetFilter()
    {
        $this->waitLoader();
        parent::resetFilter();
    }

	public function clickFirstRowToEdit()
	{
		$this->_rootElement->find('.data-grid .data-row td:nth-child(2)')->click();
		$this->waitForElementVisible('//tr[@class="data-grid-editable-row"]', Locator::SELECTOR_XPATH);
	}

	// Edit Row Actions
	public function getCancelButton()
	{
		return $this->_rootElement->find('button[data-bind="click: cancel"]');
	}

	public function getSaveButton()
	{
		return $this->_rootElement->find('button[data-bind="click: save, disable: !canSave()"]');
	}

	public function getRowEditMessage()
	{
		return $this->_rootElement->find('.data-grid-info-panel');
	}
	// End Edit Row Actions

	public function waitForGridLoader()
	{
		$this->waitForElementNotVisible($this->loader);
		$this->getTemplateBlock()->waitLoader();
	}
}