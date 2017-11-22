<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/11/2017
 * Time: 10:51
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\TestStep\TestStepInterface;
/**
 * Class CreateCustomerStep
 * @package Magento\Webpos\Test\TestStep
 */
class CreateCustomerStep implements TestStepInterface
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
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCmenu()->customerList();
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->clickAddNew()->click();
        $email = '';
        if (!empty($this->staff->getEmail())) {
            $email = str_replace('%isolation%',mt_rand(0,10000), $this->staff->getEmail());
        }
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->addValueCustomer($this->staff->getFirstName(), $this->staff->getLastName(), $email, $this->staff->getCustomerGroup());

        sleep(2);
        $this->webposIndex->getCustomerListContainer()->saveCustomer()->click();
        sleep(3);
        $result['success-message'] = $this->webposIndex->getToaster()->getWarningMessage();
        return ['result' => $result];
    }
}