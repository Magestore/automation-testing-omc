<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/11/2017
 * Time: 13:36
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckout;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class CreateCustomerWithIncorrectInforCOC04EntityTest
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckout
 */
class CreateCustomerWithIncorrectInforCOC04EntityTest extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * Inject Webpos Login pages.
     *
     * @param WebposIndex $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * Login Webpos group test.
     *
     * @param Staff $staff
     * @return void
     */

    public function test(Staff $staff, $firstName, $lastName, $email, $group, $testName)
    {
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->fill($staff);
        $this->webposIndex->getLoginForm()->clickLoginButton();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {
        }
        sleep(2);
        if (!empty($email)) {
            $email = str_replace('%isolation%',mt_rand(0,10000),$email);
        }

        $this->webposIndex->getWebposCart()->getIconChangeCustomer()->click();
        sleep(1);
        $this->webposIndex->getPopupChangeCustomer()->getCreateCustomer()->click();
        sleep(1);
        if (!empty($firstName)) {
            $this->webposIndex->getAddCustomerOnCheckout()->getCustomerFirstName()->setValue($firstName);
            sleep(1);
        }
        if (!empty($lastName)) {
            $this->webposIndex->getAddCustomerOnCheckout()->getCustomerLastName()->setValue($lastName);
            sleep(1);
        }
        if (!empty($email)) {
            $email = str_replace('%isolation%',mt_rand(0,10000),$email);
            $this->webposIndex->getAddCustomerOnCheckout()->getCustomerEmail()->setValue($email);
            sleep(1);
        }
        if (!empty($group)) {
            $this->webposIndex->getAddCustomerOnCheckout()->getCustomerOption($group)->click();
        }
        sleep(2);
        $this->webposIndex->getAddCustomerOnCheckout()->getSaveCustomer()->click();
        sleep(1);
        $result = [];
        if ($testName == 'COC04') {
            $result['first-name-error'] = $this->webposIndex->getAddCustomerOnCheckout()->getFirstNameError()->getText();
            $result['last-name-error'] = $this->webposIndex->getAddCustomerOnCheckout()->getLastNameError()->getText();
            $result['email-error'] = $this->webposIndex->getAddCustomerOnCheckout()->getEmailError()->getText();
            $result['customer-group-error'] = $this->webposIndex->getAddCustomerOnCheckout()->getCustomerGroupError()->getText();
        } elseif ($testName == 'COC05') {
            $result['email-error'] = $this->webposIndex->getAddCustomerOnCheckout()->getEmailError()->getText();
        } elseif ($testName == 'COC06') {
            $result['success'] = $this->webposIndex->getToaster()->getWarningMessage()->getText();
        }
        return ['result' => $result];
    }
}