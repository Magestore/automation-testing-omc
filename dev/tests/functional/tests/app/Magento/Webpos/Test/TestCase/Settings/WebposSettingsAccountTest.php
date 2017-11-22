<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/09/2017
 * Time: 10:56
 */

namespace Magento\Webpos\Test\TestCase\Settings;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSettingsAccountTest extends Injectable
{
	protected $webposIndex;
	protected $tearDown;
	protected $currentPassword;
	protected $newPassword;

	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(
		Staff $staff,
		$displayName = '',
		$currentPassword = '',
		$newPassword = '',
		$confirm = '',
		$samePass = false,
		$tearDown = false
	)
	{
		$this->tearDown = $tearDown;
		$this->currentPassword = $currentPassword;
		$this->newPassword = $newPassword;

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
		$this->webposIndex->getCMenu()->account();

		self::assertTrue(
			$this->webposIndex->getAccount()->isVisible(),
			"Account setting page doesn't show"
		);

		if (isset($displayName)) {
			$displayName = str_replace('%isolation%', rand(1, 99999), $displayName);
			$this->webposIndex->getAccount()->getDisplayNameField()->setValue($displayName);
		} else {
			$displayName = $this->webposIndex->getAccount()->getDisplayNameField()->getValue();
		}
		if (isset($currentPassword)) {
			$this->webposIndex->getAccount()->getCurrentPasswordField()->setValue($currentPassword);
		}
		if (isset($newPassword)) {
			$newPassword = str_replace('%isolation%', rand(111111, 999999), $newPassword);
			$this->webposIndex->getAccount()->getNewPasswordField()->setValue($newPassword);
		}
		if ($samePass) $confirm = $newPassword;
		if (isset($confirm)) {
			$this->webposIndex->getAccount()->getConfirmationField()->setValue($confirm);
		}

		$this->webposIndex->getAccount()->getSaveButton()->click();

		return [
			'staff' => $staff,
			'displayName' => $displayName,
			'currentPassword' => $currentPassword,
			'newPassword' => $newPassword
		];
	}

	public function tearDown()
	{
		if ($this->tearDown) {
			// set back password
			$this->webposIndex->open();
			sleep(1);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}

			sleep(4);
			$this->webposIndex->getMsWebpos()->clickCMenuButton();
			$this->webposIndex->getCMenu()->account();
			$this->webposIndex->getAccount()->getCurrentPasswordField()->setValue($this->newPassword);
			$this->webposIndex->getAccount()->getNewPasswordField()->setValue($this->currentPassword);
			$this->webposIndex->getAccount()->getConfirmationField()->setValue($this->currentPassword);
			$this->webposIndex->getAccount()->getSaveButton()->click();
			sleep(3);
		}

	}
}