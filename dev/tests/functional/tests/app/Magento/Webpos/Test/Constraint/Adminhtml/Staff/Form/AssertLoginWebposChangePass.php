<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 22/02/2018
 * Time: 13:55
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Form;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertLoginWebposChangePass extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $userName, $passOld, $passNew)
    {
        //check login with passOld
        $webposIndex->open();
        if ($webposIndex->getLoginForm()->isVisible())
        {
            $webposIndex->getLoginForm()->getUsernameField()->setValue($userName);
            $webposIndex->getLoginForm()->getPasswordField()->setValue($passOld);
            $webposIndex->getLoginForm()->clickLoginButton();
        }
        $webposIndex->getToaster()->waitForElementVisible('.message');
        \PHPUnit_Framework_Assert::assertTrue(
            true,
            'Message warning doen not display'
        );
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getFirstScreen()->isVisible(),
            'LoginTest webpos with old pass is incorrect'
        );

        //check login with passNew
        $webposIndex->open();
        if ($webposIndex->getLoginForm()->isVisible()) {
            $webposIndex->getLoginForm()->getUsernameField()->setValue($userName);
            $webposIndex->getLoginForm()->getPasswordField()->setValue($passNew);
            $webposIndex->getLoginForm()->clickLoginButton();
            $webposIndex->getMsWebpos()->waitForSyncDataVisible();
            $time = time();
            $timeAfter = $time + 360;
            while ($webposIndex->getFirstScreen()->isVisible() && $time < $timeAfter){
                $time = time();
            }
            sleep(2);
        }
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutWebposCart()->isVisible(),
            'LoginTest webpos with new pass is incorrect'
        );
    }

    /**
     * Text of Required field message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Pass is correct';
    }
}
