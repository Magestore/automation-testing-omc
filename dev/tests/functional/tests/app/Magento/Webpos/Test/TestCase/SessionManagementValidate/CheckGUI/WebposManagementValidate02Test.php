<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 3/8/2018
 * Time: 1:55 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposManagementValidate02Test extends Injectable
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
    public function __inject(
        WebposIndex $webposIndex
    ) {
        $this->webposIndex = $webposIndex;
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
        //Create role and staff for role
        $webposRole->persist();
        $staff = $webposRole->getDataFieldConfig('staff_id')['source']->getStaffs()[0];
        //Login
        $this->login($staff);

        //click menu
        $this->webposIndex->getMsWebpos()->getCMenuButton()->click();
        $this->webposIndex->getCMenu()->getSessionManagement();

    }

    public function login(Staff $staff)
    {
        $username = $staff->getUsername();
        $password = $staff->getPassword();
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

