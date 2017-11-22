<?php
/**
 * Created by: thomas
 * Date: 12/10/2017
 * Time: 09:21
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\CustomerList\Complain;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class CancelCustomerComplainEntityTest
 * @package Magento\Webpos\Test\TestCase\CustomerList
 */
class CancelCustomerComplainEntityTest extends Injectable
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
    public function test(Staff $staff, $emailInitial)
    {
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->fill($staff);
        $this->webposIndex->getLoginForm()->clickLoginButton();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {
        }
        sleep(2);

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(1);
        $this->webposIndex->getCmenu()->customerList();
        sleep(1);
        $this->webposIndex->getCustomerListContainer()->searchCustomer()->setValue($emailInitial);
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->clickAddComplain()->click();
        sleep(1);
        $this->webposIndex->getCustomerListContainer()->closeCustomerComplain()->click();
        sleep(2);
    }
}
