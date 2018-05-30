<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 21/02/2018
 * Time: 08:07
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCCCheckGuiTest
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\CheckGUI
 *
 * Precondition:
 * "1. Login Webpos as a staff
 *
 * Steps:
 * 1. Click on Add customer icon
 *
 * Acceptance:
 * "Open Customer list popup including:
 * - Buttons: Create customer, Use Guest
 * - Search textbox with place holder: ""Search by name/ email/ phone""
 * - List of exist customers contains customer name and telephone"
 *
 */
class WebposCCCheckGuiTest extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;


    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test(
        $clickCreateCustomer = false
    )
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        // Select an existing customer
        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
        $this->webposIndex->getCheckoutChangeCustomer()->waitForCustomerList();

        if ($clickCreateCustomer) {
            $this->webposIndex->getCheckoutChangeCustomer()->getAddNewCustomerButton()->click();
        }

    }
}