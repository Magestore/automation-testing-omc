<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/09/2017
 * Time: 16:17
 */

namespace Magento\Webpos\Test\TestCase\Settings;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSettingsLogoutTest extends Injectable
{
	protected $webposIndex;

	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(Staff $staff)
	{
		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()){
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		}

		sleep(2);
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->logout();

		self::assertTrue(
			$this->webposIndex->getModal()->getModalPopup()->isVisible(),
			'confirm popup is not displayed'
		);

		self::assertEquals(
			"Are you sure you want to logout?",
			$this->webposIndex->getModal()->getPopupMessage(),
			'Popup content is wrong'
		);
		$this->webposIndex->getModal()->getCancelButton()->click();
		self::assertFalse(
			$this->webposIndex->getModal()->getModalPopup()->isVisible(),
			'cancel - confirm popup is hided'
		);
		self::assertTrue(
			$this->webposIndex->getCMenu()->isVisible(),
			'cancel - staff is not still login'
		);

		$this->webposIndex->getCMenu()->logout();
		$this->webposIndex->getModal()->getOkButton()->click();

		self::assertFalse(
			$this->webposIndex->getModal()->getModalPopup()->isVisible(),
			"Logout - Ok - confirm popup doesn't hide"
		);
		sleep(5);
		self::assertTrue(
			$this->webposIndex->getLoginForm()->isVisible(),
			'Staff logged out - Login form displayed'
		);
	}
}