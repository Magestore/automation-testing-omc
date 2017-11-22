<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/09/2017
 * Time: 14:16
 */

namespace Magento\Webpos\Test\TestCase\Settings;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSettingLoginTest extends Injectable
{
	protected $webposIndex;

	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(Staff $staff=null)
	{
		$this->webposIndex->open();
		if (!empty($staff)){
			$this->webposIndex->getLoginForm()->fill($staff);
		}
		$this->webposIndex->getLoginForm()->clickLoginButton();
	}
}