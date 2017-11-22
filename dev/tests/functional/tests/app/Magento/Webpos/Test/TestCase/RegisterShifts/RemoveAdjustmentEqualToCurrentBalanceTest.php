<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-22 08:34:31
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   Thomas
 * @Last Modified time: 2017-11-02 16:00:07
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\RegisterShifts;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class RemoveAdjustmentEqualToCurrentBalanceTest extends Injectable
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
    public function test(Staff $staff)
    {
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->fill($staff);
        $this->webposIndex->getLoginForm()->clickLoginButton();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {}
        sleep(3);

        // Click Menu Button to see menu dropdown
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCmenu()->registerShift();
        $this->webposIndex->getRegisterShift()->selectAddShift();
        sleep(3);
        $amountValue = 100;
        $this->webposIndex->getRegisterShift()->registerShiftNotClose($amountValue);
        sleep(3);
        $this->webposIndex->getRegisterShift()->addValueToMakeAdjustment('add', $amountValue);
        $this->webposIndex->getRegisterShift()->clickButtonCloseMakeAdjustmentDone();

        $this->webposIndex->getRegisterShift()->addValueToMakeAdjustment('remove', 2*$amountValue);
        $this->webposIndex->getRegisterShift()->clickButtonCloseMakeAdjustmentDone();
    }
}
