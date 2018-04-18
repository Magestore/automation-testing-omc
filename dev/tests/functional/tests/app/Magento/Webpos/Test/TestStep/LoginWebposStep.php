<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/11/2017
 * Time: 10:22
 */
namespace  Magento\Webpos\Test\TestStep;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Mtf\Config\DataInterface;

/**
 * Class LoginWebposStep
 * @package Magento\Webpos\Test\TestStep
 */
class LoginWebposStep implements TestStepInterface
{
	/**
	 * System config.
	 *
	 * @var DataInterface
	 */
	protected $configuration;

	/**
	 * Webpos Index page.
	 * @var WebposIndex
	 */
	protected $webposIndex;


	/**
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	/**
	 * @param WebposIndex $webposIndex
	 */
	public function __construct(
		WebposIndex $webposIndex,
		DataInterface $configuration,
		FixtureFactory $fixtureFactory
	) {
		$this->webposIndex = $webposIndex;
		$this->configuration = $configuration;
		$this->fixtureFactory = $fixtureFactory;
	}

	public function run()
	{
		$username = $this->configuration->get('application/0/backendLogin/0/value');
		$password = $this->configuration->get('application/0/backendPassword/0/value');
		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->getUsernameField()->setValue($username);
			$this->webposIndex->getLoginForm()->getPasswordField()->setValue($password);
			$this->webposIndex->getLoginForm()->clickLoginButton();
//      $this->webposIndex->getMsWebpos()->waitForSyncDataAfterLogin(); 
            sleep(3);
			//check if WrapWarningForm is visible when this staff has been logged in
            if ($this->webposIndex->getWrapWarningForm()->isVisible()) {
                $this->webposIndex->getWrapWarningForm()->getButtonContinue()->click();
            }
			$this->webposIndex->getMsWebpos()->waitForSyncDataVisible();
			$time = time();
			$timeAfter = $time + 360;
			while ($this->webposIndex->getFirstScreen()->isVisible() && $time < $timeAfter){
                $time = time();
            }
			sleep(2);
		}

		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

		$data = [
			'username' => $username,
			'password' => $password
		];
		return $this->fixtureFactory->createByCode('staff' , ['data' => $data]);
	}
}