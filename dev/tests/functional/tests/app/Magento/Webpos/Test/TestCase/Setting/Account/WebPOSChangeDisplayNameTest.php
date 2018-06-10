<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 13:29
 */

namespace Magento\Webpos\Test\TestCase\Setting\Account;

use Magento\Mtf\Config\DataInterface;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebPOSChangeDisplayNameTest
 * @package Magento\Webpos\Test\TestCase\Setting\Account
 * SET03 & SET04
 * Precondition and setup steps
 * 1. Login webpos as a staff
 *
 * SET03
 * Steps
 * 1. Click on [Account] menu
 * 2. Edit [Display name]
 * Enter incorrect current password
 * 3. Save
 * Acceptance Criteria
 * 3. Save Display name unsuccessfully and show message: "Error: Old password is incorrect!
 *
 * SET04
 * Steps
 * 1. Click on [Account] menu
 * 2. Edit [Display name]
 * Enter correct current password
 * 3. Save
 * Acceptance Criteria
 * 3.
 * - Save account successfully and show message: ""success: Your account is saved successfully!""
 * - Display name will be updated and changed on Webpos checkout page
 * - Dispaly name of this staff in back end will be updated too
 */
class WebPOSChangeDisplayNameTest extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;
    protected $username;
    protected $password;
    protected $testCaseId;

    /**
     * System config.
     *
     * @var DataInterface
     */
    protected $configuration;

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
     * @param $displayName
     * @param $testCaseID
     * @param $currentPassword
     */
    public function test($displayName, $testCaseID, $currentPassword)
    {
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
        if ($testCaseID == 'SET03') {
            $this->webposIndex->getStaffSettingFormMainAccount()->getCurrentPassword()->setValue($currentPassword);
        } elseif ($testCaseID == 'SET04') {
            $this->webposIndex->getStaffSettingFormMainAccount()->getCurrentPassword()->setValue($password);
            $username = $this->configuration->get('application/0/backendLogin/0/value');
            $password = $this->configuration->get('application/0/backendPassword/0/value');
            $this->username = $username . ' ' . $username;
            $this->password = $password;
        }
        $this->webposIndex->getStaffSettingFormMainAccount()->getDisplayName()->setValue($displayName);
        $this->webposIndex->getStaffSettingFormFooter()->getSaveButton()->click();
        $this->testCaseId = $testCaseID;
    }

    public function tearDown()
    {
        if ($this->testCaseId == 'SET04') {
            $this->webposIndex->open();
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getMsWebpos()->waitCartLoader();

            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->account();
            sleep(1);
            $this->webposIndex->getStaffSettingFormMainAccount()->getDisplayName()->setValue($this->username);
            $this->webposIndex->getStaffSettingFormMainAccount()->getCurrentPassword()->setValue($this->password);
            $this->webposIndex->getStaffSettingFormFooter()->getSaveButton()->click();
            $this->webposIndex->getToaster()->waitWarningMessageShow();
        }
    }
}