<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 3/13/2018
 * Time: 8:31 AM
 */
namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\OpenSession;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Config\DataInterface;

class WebposManagementValidate03Test extends Injectable
{

    /**
     * @var WebposIndex
     */
    private $webposIndex;

    /**
     * Inject WebposIndex pages.
     *
     * @param $webposIndex
     * @return void
     */

    protected $configuration;
    /**
     * @var
     */
    protected $fixtureFactory;

    public function __inject(
        WebposIndex $webposIndex,
        DataInterface $configuration,
        FixtureFactory $fixtureFactory
    ) {
        $this->webposIndex = $webposIndex;
        $this->configuration = $configuration;
        $this->fixtureFactory = $fixtureFactory;
    }

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes_MS57']
        )->run();
    }

    public function test(WebposRole $webposRole)
    {
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposChooseLocationStep'
        )->run();

        //click menu
        $this->webposIndex->getMsWebpos()->getCMenuButton()->click();
        $this->webposIndex->getCMenu()->getSessionManagement();
        $this->webposIndex->getMsWebpos()->clickOutsidePopup();
        $this->webposIndex->getOpenSessionPopup()->getCancelButton()->click();

//        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
//        sleep(1);
//
//        // End session
//        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
//        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
//        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
//        $this->webposIndex->getSessionShift()->waitForElementNotVisible('.btn-close-shift');

    }

    public function login()
    {
        $username = $this->configuration->get('application/0/backendLogin/0/value');
        $password = $this->configuration->get('application/0/backendPassword/0/value');
        $this->webposIndex->open();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
        if ($this->webposIndex->getLoginForm()->isVisible()) {
            $this->webposIndex->getLoginForm()->getUsernameField()->setValue($username);
            $this->webposIndex->getLoginForm()->getPasswordField()->setValue($password);
            $this->webposIndex->getLoginForm()->clickLoginButton();
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="webpos-location"]');
            $this->webposIndex->getLoginForm()->setLocation('Store Address');
            $this->webposIndex->getLoginForm()->setPos('Store POS');
            $this->webposIndex->getLoginForm()->getEnterToPos()->click();
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
            $this->webposIndex->getMsWebpos()->waitForSyncDataVisible();
            $time = time();
            $timeAfter = $time + 360;
            while ($this->webposIndex->getFirstScreen()->isVisible() && $time < $timeAfter){
                $time = time();
            }
            sleep(2);
        }
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no_MS57']
        )->run();
    }
}

