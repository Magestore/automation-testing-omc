<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 08:55
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Role\Edit\Tab\User;

use Magento\Backend\Test\Block\Widget\Grid as AbstractGrid;

/**
 * Class Grid
 * Users grid in roles users tab
 */
class Grid extends AbstractGrid
{
	/**
	 * Grid filters' selectors
	 *
	 * @var array
	 */
	protected $filters = [
		'in_staff' => [
			'selector' => '[name="in_staff"]',
		],
		'staff_id_from' => [
			'selector' => '[name="staff_id[from]"]',
		],
		'staff_id_to' => [
			'selector' => '[name="staff_id[to]"]',
		],
		'username' => [
			'selector' => '[name="username"]',
		],
		'user_display_name' => [
			'selector' => '[name="user_display_name"]',
		],
		'email' => [
			'selector' => '[name="email"]',
		],
		'status' => [
			'selector' => '[name="status"]',
		],
	];

	/**
	 * Locator value for role name column
	 *
	 * @var string
	 */
	protected $selectItem = '.col-in_staff input';
}