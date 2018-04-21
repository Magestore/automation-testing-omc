<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 13:29
 */

namespace Magento\Webpos\Test\TestCase\Setting\Account;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Config\DataInterface;
/**
 * Class WebPOSChangeDisplayNameTest
 * @package Magento\Webpos\Test\TestCase\Setting\Account
 */
class WebPOSChangeDisplayNameTest extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;
    protected $username;
    protected $testCaseId;

    /**
     * System config.
     *
     * @var DataInterface
     */
    protected $configuration;

    public function __inject(
        DataInterface $configuration,
        WebposIndex $webposIndex
    )
    {
        $this->configuration = $configuration;
        $this->webposIndex = $webposIndex;
    }

    public function test($displayName, $testCaseID, $currentPassword)
    {
        $password = $this->configuration->get('application/0/backendPassword/0/value');
        // Login webpos
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
            $this->username=$username . ' ' . $username;
        }
        $this->webposIndex->getStaffSettingFormMainAccount()->getDisplayName()->setValue($displayName);
        $this->webposIndex->getStaffSettingFormFooter()->getSaveButton()->click();
        $this->testCaseId = $testCaseID;
    }

    public function tearDown()
    {
        if ($this->testCaseId == 'SET04') {
            $this->webposIndex->getStaffSettingFormMainAccount()->getDisplayName()->setValue($this->username);
            $this->webposIndex->getStaffSettingFormFooter()->getSaveButton()->click();
        }
    }
}