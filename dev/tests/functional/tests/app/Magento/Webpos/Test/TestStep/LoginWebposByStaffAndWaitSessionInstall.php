<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/12/2018
 * Time: 9:25 AM
 */

namespace Magento\Webpos\Test\TestStep;

class LoginWebposByStaffAndWaitSessionInstall extends LoginWebposByStaff
{

    public function run()
    {
        $username = $this->staff->getUsername();
        $password = $this->staff->getPassword();
        $this->webposIndex->open();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
        if ($this->webposIndex->getLoginForm()->isVisible()) {
            $this->webposIndex->getLoginForm()->getUsernameField()->setValue($username);
            $this->webposIndex->getLoginForm()->getPasswordField()->setValue($password);
            $this->webposIndex->getLoginForm()->clickLoginButton();
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="webpos-location"]');
            if ($this->location) {
                $this->webposIndex->getLoginForm()->setLocation($this->location->getDisplayName());
            }
            if ($this->pos) {
                $this->webposIndex->getLoginForm()->setPos($this->pos->getPosName());
            }
            if ($this->location || $this->pos) {
                $this->webposIndex->getLoginForm()->getEnterToPos()->click();
            }
        }

        /**
         *  wait sync complete
         */
        while ( !$this->webposIndex->getSessionInstall()->isVisible()) {
            sleep(1);
        }

        while ( !$this->webposIndex->getSessionInstall()->getPercent()->isVisible()) {
            sleep(1);
        }

        while (
            ( rtrim($this->webposIndex->getSessionInstall()->getPercent()->getText(),"%") * 1 ) < 95
        ) {
            sleep(1);
        }

        sleep(2);

        if (!$this->hasWaitOpenSessionPopup) return true;

        if ($this->pos || $this->location) {
            while (! $this->webposIndex->getOpenSessionPopup()->isVisible()) {
                sleep(1);
            }

            while (! $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->isVisible()) {
                sleep(1);
            }
        }

        while ($this->webposIndex->getOpenSessionPopup()->getLoadingElement()->isVisible()) {
            sleep(1);
        }


        if ($this->hasOpenSession) {
            $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();

            /** wait done open request */
            while ( !$this->webposIndex->getListShift()->getFirstItemShift()->isVisible()) {
                sleep(1);
            }

            return true;
        }

        return true;
    }
}