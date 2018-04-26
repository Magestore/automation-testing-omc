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
        //Login
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();

        //click menu
        $this->webposIndex->getMsWebpos()->getCMenuButton()->click();
        $this->webposIndex->getCMenu()->getSessionManagement();
        $this->webposIndex->getMsWebpos()->clickOutsidePopup();
//        $this->webposIndex->getSessionShift()->getAddSession()->click();

//        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
//        sleep(1);
//
//        // End session
//        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
//        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
//        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
//        $this->webposIndex->getSessionShift()->waitForElementNotVisible('.btn-close-shift');

    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no_MS57']
        )->run();
    }
}

