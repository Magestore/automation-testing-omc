<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/09/2017
 * Time: 13:51
 */

namespace Magento\Webpos\Test\TestCase\Settings;


use Magento\Backend\Test\Page\Adminhtml\Dashboard;
use Magento\Mtf\TestCase\Injectable;

class WebposSettingsOpenFromBackendTest extends Injectable
{
	protected $dashboard;

	public function __inject(
		Dashboard $dashboard
	)
	{
		$this->dashboard = $dashboard;
	}

	public function test($menuItem)
	{
		$this->dashboard->open();
		$this->dashboard->getMenuBlock()->navigate($menuItem);
	}
}