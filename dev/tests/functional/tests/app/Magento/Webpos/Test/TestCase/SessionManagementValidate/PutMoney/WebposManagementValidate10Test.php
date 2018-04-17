<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 3/13/2018
 * Time: 10:08 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\PutMoney;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Fixture\Denomination;

class WebposManagementValidate10Test extends Injectable
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

    public function test(Denomination $denomination)
    {
        $denomination->persist();
        //Login
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposChooseLocationStep'
        )->run();

        //click menu
        $this->webposIndex->getMsWebpos()->getCMenuButton()->click();
        $this->webposIndex->getCMenu()->getSessionManagement();
        $this->webposIndex->getMsWebpos()->clickOutsidePopup();
//        $this->webposIndex->getSessionShift()->getAddSession()->click();
        $this->webposIndex->getOpenSessionPopup()->setQtyCoinBill(10);

        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        sleep(2);

        $this->webposIndex->getSessionShift()->getPutMoneyInButton()->click();


        $this->webposIndex->getPutMoneyInPopup()->getBtnCancel()->click();
        // End session
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
        $this->webposIndex->getSessionConfirmModalPopup()->getOkButton()->click();
        $this->webposIndex->getSessionSetReasonPopup()->getConfirmButton()->click();
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        $this->webposIndex->getSessionShift()->waitForElementNotVisible('.btn-close-shift');

    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no_MS57']
        )->run();
    }
}

