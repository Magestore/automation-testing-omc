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
            $this->webposIndex->getWrapWarningForm()->waitForWrapWarningFormVisible();
			//check if WrapWarningForm is visible when this staff has been logged in
            if ($this->webposIndex->getWrapWarningForm()->isVisible()) {
                $this->webposIndex->getWrapWarningForm()->getButtonContinue()->click();
            }
            // check if LoginForm must choose location and pos
            $this->webposIndex->getLoginForm()->waitForLoginFormVisiable();
            if ($this->webposIndex->getLoginForm()->getLocationID()->isVisible()) {
                if ($this->webposIndex->getLoginForm()->getLocationItem('Store Address')->isVisible()) {
                    $this->webposIndex->getLoginForm()->selectLocation('Store Address')->click();
                }
            }
            if ($this->webposIndex->getLoginForm()->getPosID()->isVisible()) {
                if ($this->webposIndex->getLoginForm()->getPosItem('Store POS')->isVisible()) {
                    $this->webposIndex->getLoginForm()->selectPos('Store POS')->click();
                }
            }
            if ($this->webposIndex->getLoginForm()->getEnterToPos()->isVisible()) {
                $this->webposIndex->getLoginForm()->getEnterToPos()->click();
            }
            $this->webposIndex->getMsWebpos()->waitForSyncDataAfterLogin();
		}

		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

		$data = [
			'username' => $username,
			'password' => $password
		];
		return $this->fixtureFactory->createByCode('staff' , ['data' => $data]);
	}
}