<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/11/2017
 * Time: 10:22
 */
namespace  Magento\Webpos\Test\TestStep;

use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\TestStep\TestStepInterface;

/**
 * Class LoginWebposStep
 * @package Magento\Webpos\Test\TestStep
 */
class LoginWebposStep implements TestStepInterface
{
    /**
     * Webpos Index page.
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * Webpos Index page.
     *
     * @var Staff
     */
    protected $staff;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __construct(
        WebposIndex $webposIndex,
        Staff $staff
    ) {
        $this->webposIndex = $webposIndex;
        $this->staff = $staff;
    }

    /**
     * Update checkout agreement.
     *
     * @return array
     */
    public function run()
    {
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->getUsernameField()->setValue($this->staff->getUsername());
        $this->webposIndex->getLoginForm()->getPasswordField()->setValue($this->staff->getPassword());
        $this->webposIndex->getLoginForm()->clickLoginButton();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {}
        sleep(2);
    }
}
