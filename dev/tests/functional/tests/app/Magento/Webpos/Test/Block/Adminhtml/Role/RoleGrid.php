<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 08:20
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Role;


use Magento\Mtf\Client\Element\SimpleElement;
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
}