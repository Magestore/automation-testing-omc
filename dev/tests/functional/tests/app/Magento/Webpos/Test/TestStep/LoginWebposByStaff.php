<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/12/2018
 * Time: 9:25 AM
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class LoginWebposByStaff
 * @package Magento\Webpos\Test\TestStep
 */
class LoginWebposByStaff implements TestStepInterface
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var Staff
     */
    protected $staff;

    /**
     * @var Location
     */
    protected $location;

    /**
     * @var Pos
     */
    protected $pos;

    /**
     * @var boolean hasOpenSession
     */
    protected $hasOpenSession;

    /**
     * @var boolean hasWaitOpenSessionPopup
     */
    protected $hasWaitOpenSessionPopup;

    /**
     * LoginWebposByStaff constructor.
     * @param WebposIndex $webposIndex
     * @param Staff $staff
     * @param Location|null $location
     * @param Pos|null $pos
     * @param bool $hasOpenSession
     * @param bool $hasWaitOpenSessionPopup
     */
    public function __construct(
        WebposIndex $webposIndex,
        Staff $staff,
        Location $location = null,
        Pos $pos = null,
        $hasOpenSession = true,
        $hasWaitOpenSessionPopup = true
    ) {
        $this->webposIndex = $webposIndex;
        $this->staff = $staff;
        $this->location = $location;
        $this->pos = $pos;
        $this->hasOpenSession = $hasOpenSession;
        $this->hasWaitOpenSessionPopup = $hasWaitOpenSessionPopup;
    }

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
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
            $this->webposIndex->getMsWebpos()->waitForSyncDataVisible();
            $time = time();
            $timeAfter = $time + 360;
            while ($this->webposIndex->getFirstScreen()->isVisible() && $time < $timeAfter){
                $time = time();
            }
            sleep(2);
        }
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
//        $this->webposIndex->getMsWebpos()->waitCartLoader();
        if ($this->location || $this->pos) {
            if($this->webposIndex->getMsWebpos()->isVisible('[id="popup-open-shift"]')){
                $this->hasWaitOpenSessionPopup && $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-open-shift"]');
            }
            sleep(2);
            $this->webposIndex->getOpenSessionPopup()->waitForElementNotVisible('.indicator[data-bind="visible:loading"]');
            if ($this->hasOpenSession) {
                while (! $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->isVisible()) {

                }
                $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
                $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-open-shift"]');
            }
        }

    }
}