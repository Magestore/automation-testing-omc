<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 22/02/2018
 * Time: 08:13
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\ShippingAddressPopup;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCCShippingAddressPopupCheckGUITest
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\ShippingAddressPopup
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Click on Add new customer icon"
 *
 * Steps:
 * "1. Click on [Create customer] button
 * 2. Click on Add shipping address icon"
 *
 * Acceptance:
 * "2. Show Add Shipping Address popup with:
 * - Fields: First name, Last name, Company, Phone, Street1, Street2, City, Zip Code, Country, State or Province, VAT
 * - Check box: Billing Address and Shipping Address are the same
 * - Action: Cancel, Save"
 *
 */
class WebposCCShippingAddressPopupCheckGUITest extends Injectable
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
        $action = ''
    )
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
        $this->webposIndex->getCheckoutChangeCustomer()->waitForCustomerList();

        $this->webposIndex->getCheckoutChangeCustomer()->getAddNewCustomerButton()->click();
        sleep(1);
        $this->webposIndex->getCheckoutAddCustomer()->getAddShippingAddressIcon()->click();
        sleep(1);


        if (strcmp($action, 'cancel') == 0) {
            $this->webposIndex->getCheckoutAddShippingAddress()->getCancelButton()->click();
        } elseif (strcmp($action, 'save') == 0) {
            $this->webposIndex->getCheckoutAddShippingAddress()->getSaveButton()->click();
        }
    }
}