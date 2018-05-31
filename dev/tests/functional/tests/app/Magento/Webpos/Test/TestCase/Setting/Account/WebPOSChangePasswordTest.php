<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 13:53
 */

namespace Magento\Webpos\Test\TestCase\Setting\Account;

use Magento\Mtf\Config\DataInterface;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebPOSChangePasswordTest
 * @package Magento\Webpos\Test\TestCase\Setting\Account
 */
class WebPOSChangePasswordTest extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * System config.
     *
     * @var DataInterface
     */
    protected $configuration;

    protected $testCaseID;
    protected $newPassword;

    /**
     * @param DataInterface $configuration
     * @param WebposIndex $webposIndex
     */
    public function __inject(
        DataInterface $configuration,
        WebposIndex $webposIndex
    )
    {
        $this->configuration = $configuration;
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param $testID
     * @param $currentPassword
     * @param $password
     * @param $passwordConfirmation
     */
    public function test($testID, $currentPassword, $password, $passwordConfirmation)
    {
        if ($testID == 'SET07' || $testID == 'SET08') {
            $currentPassword = $this->configuration->get('application/0/backendPassword/0/value');
        }
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->account();
        sleep(1);
        $this->webposIndex->getStaffSettingFormMainAccount()->getCurrentPassword()->setValue($currentPassword);
        if ($testID == 'SET05') {
            $this->webposIndex->getStaffSettingFormMainAccount()->getPassword()->setValue($password);
        } elseif ($testID == 'SET07') {
            $this->webposIndex->getStaffSettingFormMainAccount()->getPassword()->setValue($password);
            $this->webposIndex->getStaffSettingFormMainAccount()->getPasswordConfirmation()->setValue($passwordConfirmation);
        } elseif ($testID == 'SET08') {
            $this->webposIndex->getStaffSettingFormMainAccount()->getPassword()->setValue($password);
            $this->webposIndex->getStaffSettingFormMainAccount()->getPasswordConfirmation()->setValue($passwordConfirmation);
        }
        $this->webposIndex->getStaffSettingFormFooter()->getSaveButton()->click();

        $this->testCaseID = $testID;
        $this->newPassword = $password;
    }

    public function tearDown()
    {
        if ($this->testCaseID == 'SET08') {
            $username = $this->configuration->get('application/0/backendLogin/0/value');
            $password = $this->configuration->get('application/0/backendPassword/0/value');
            // LoginTest webpos
            $staff = $this->objectManager->getInstance()->create(
                'Magento\Webpos\Test\TestStep\LoginWebposStep'
            )->run();
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->account();
            sleep(1);
            $this->webposIndex->getStaffSettingFormMainAccount()->getDisplayName()->setValue($username . ' ' . $username);
            $this->webposIndex->getStaffSettingFormMainAccount()->getCurrentPassword()->setValue($this->newPassword);
            $this->webposIndex->getStaffSettingFormMainAccount()->getPassword()->setValue($password);
            $this->webposIndex->getStaffSettingFormMainAccount()->getPasswordConfirmation()->setValue($password);
            $this->webposIndex->getStaffSettingFormFooter()->getSaveButton()->click();
        }
    }
}