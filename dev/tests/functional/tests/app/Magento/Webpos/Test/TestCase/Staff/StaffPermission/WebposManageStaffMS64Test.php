<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/7/2018
 * Time: 10:25 AM
 */

namespace Magento\Webpos\Test\TestCase\Staff\StaffPermission;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * *
 * Staff Permission
 * Testcase MS64 - Permission
 *
 * Precondition:
 * 1. Go to backend > Sales > Manage Roles
 * 2. Add a new role "TEST"
 * - Permission: Manage Order Created at Location of Staff
 * 3. Add 2 staffs:
 * - Staff 1: location 1
 * - Staff 2: location 1, role "TEST"
 * 4. Login webpos by Satff 1
 * 5. Create some pending orders (without paid money) successfully
 * 6. Logout
 *
 * Steps
 * 1. Login webpos by Staff 2
 * 2. Go to Orders history page
 * 3. View detail page of some orders created by Staff 1
 * 4.Take payment
 * 5. Create shippment
 * 6. Create Invoice
 * 7. Create refund
 * 8. Send email
 * 9. Print
 * 10. Add Comment
 * 11. Re-order
 *
 * Acceptance Criteria
 * 4. Take payment successfully and show a new notification
 * 5. Create shippment successfully, show a new notification and order status change to processing
 * 6. Create invoice successfully and show a new notification
 * 7. Create refund successfully and show a new notification
 * 8. Send email to successfully and show a new notification
 * 9. Show Print popup to print invoice when click on Print button
 * 10. Add comment successfully, update comment history and show a new notification
 * 11. When click on Re-order button, all items of current order will be loaded to cart
 *
 * Class WebposManageStaffMS64Test
 * @package Magento\Webpos\Test\TestCase\Staff\StaffPermission
 */
class WebposManageStaffMS64Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    private $webposIndex;

    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * Inject WebposIndex pages.
     *
     * @param $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no']
        )->run();
        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'staff_ms61']);
        return ['staffData' => $staff->getData()];
    }

    /**
     * @param WebposRole $webposRole
     * @param $products
     * @param $staffData
     */
    public function test(WebposRole $webposRole, $products, $staffData)
    {
        //Create role and staff for role
        /**@var Location $location */
        $location = $this->fixtureFactory->createByCode('location', ['dataset' => 'default']);
        $location->persist();
        $locationId = $location->getLocationId();
        $posData['pos_name'] = 'Pos Test %isolation%';
        $posData['status'] = 'Enabled';
        $array = [];
        $array[] = $locationId;
        $posData['location_id'] = $array;
        /**@var Pos $pos */
        $pos = $this->fixtureFactory->createByCode('pos', ['data' => $posData]);
        $pos->persist();
        $posId = $pos->getPosId();
        $array = [];
        $array[] = $locationId;
        $staffData['location_id'] = $array;
        $array = [];
        $array[] = $posId;
        $staffData['pos_ids'] = $array;
        $staffData['username'] = 'test%isolation%';
        $staffData['display_name'] = 'Staff %isolation%';
        $staffData['email'] = 'test%isolation%@trueplus.vn';
        /**@var Staff $staff1 */
        $staff1 = $this->fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff1->persist();
        /**@var Staff $staff2 */
        $staff2 = $this->fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff2->persist();
        $roleData = $webposRole->getData();
        $array = [];
        $array[] = $staff2->getStaffId();
        $roleData['staff_id'] = $array;
        $role = $this->fixtureFactory->createByCode('webposRole', ['data' => $roleData]);
        $role->persist();
        //Create product
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        //LoginTest
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff1,
                'hasOpenSession' => null,
                'hasWaitOpenSessionPopup' => null
            ]
        )->run();
        // Add product to cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AddProductToCartStep',
            ['products' => $products]
        )->run();
        // Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue(0);
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="toaster"]');
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //Logout
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->logout();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('.modals-wrapper');
        $this->webposIndex->getModal()->getOkButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('#checkout-loader.loading-mask');

        //LoginTest by staff2
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff2,
                'hasOpenSession' => null,
                'hasWaitOpenSessionPopup' => null
            ]
        )->run();
        $this->webposIndex->open();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="c-button--push-left"]');
        //Go to orders history
        $this->webposIndex->getMsWebpos()->getCMenuButton()->click();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitForFirstOrderVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(1);
        //Take payment
        $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForTakePaymentButtonVisible();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="payment-popup"]');
        sleep(1);
        if ($this->webposIndex->getOrderHistoryPayment()->getCashInMethod()->isVisible()) {
            $this->webposIndex->getOrderHistoryPayment()->getCashInMethod()->click();
            $this->webposIndex->getOrderHistoryPayment()->getSubmitButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementVisible('.modals-wrapper');
            sleep(2);
            $this->webposIndex->getModal()->getOkButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="toaster"]');
            $this->assertEquals(
                'Create payment successfully!',
                $this->webposIndex->getToaster()->getWarningMessage()->getText(),
                'Create payment success message is wrong.'
            );
            //Open notifications
            $this->webposIndex->getNotification()->getNotificationBell()->click();
            $this->assertTrue(
                $this->webposIndex->getNotification()->getFirstNotification()->isVisible(),
                'Take payment new notification haven\'t been created.'
            );
            $this->assertEquals(
                'Create payment successfully!',
                $this->webposIndex->getNotification()->getFirstNotificationText(),
                'Create payment notification message is wrong.'
            );
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="toaster"]');
            sleep(2);
            $this->webposIndex->getNotification()->getNotificationBell()->click();

            //Create shipment
            $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="form-add-note-order"]');
            $this->webposIndex->getOrderHistoryAddOrderNote()->getShipButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="shipment-popup"]');
            $this->webposIndex->getOrderHistoryShipment()->getSubmitButton()->click();
            sleep(2);
            $this->webposIndex->getMsWebpos()->waitForElementVisible('.modals-wrapper');
            $this->webposIndex->getModal()->getOkButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="toaster"]');
            $this->assertEquals(
                'The shipment has been created successfully.',
                $this->webposIndex->getToaster()->getWarningMessage()->getText(),
                'Create shipment success message is wrong.'
            );
            //Open notifications
            $this->webposIndex->getNotification()->getNotificationBell()->click();
            $this->assertTrue(
                $this->webposIndex->getNotification()->getFirstNotification()->isVisible(),
                'Create shipment new notification haven\'t been created.'
            );
            $this->assertEquals(
                'The shipment has been created successfully.',
                $this->webposIndex->getNotification()->getFirstNotificationText(),
                'Create shipment notification message is wrong.'
            );
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="toaster"]');
            $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForProcessingStatusVisisble();
            sleep(2);
            $this->webposIndex->getNotification()->getNotificationBell()->click();

            //Create invoice
            $this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="invoice-popup"]');
            $this->webposIndex->getOrderHistoryInvoice()->getSubmitButton()->click();
            sleep(2);
            $this->webposIndex->getMsWebpos()->waitForElementVisible('.modals-wrapper');
            $this->webposIndex->getModal()->getOkButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="toaster"]');
            $this->assertEquals(
                'The invoice has been created successfully.',
                $this->webposIndex->getToaster()->getWarningMessage()->getText(),
                'Invoice success message is wrong.'
            );
            //Open notifications
            $this->webposIndex->getNotification()->getNotificationBell()->click();
            $this->assertTrue(
                $this->webposIndex->getNotification()->getFirstNotification()->isVisible(),
                'Create invoice new notification haven\'t been created.'
            );
            $this->assertEquals(
                'The invoice has been created successfully.',
                $this->webposIndex->getNotification()->getFirstNotificationText(),
                'Create invoice notification message is wrong.'
            );
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="toaster"]');
            sleep(2);
            $this->webposIndex->getNotification()->getNotificationBell()->click();
            //Create refund
            $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="form-add-note-order"]');
            $this->webposIndex->getOrderHistoryAddOrderNote()->getRefundButton()->click();
            sleep(2);
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="creditmemo-popup-form"]');
            foreach ($products as $item) {
                $productName = $item['product']->getName();
                $this->webposIndex->getOrderHistoryRefund()->getItemQtyToRefundInput($productName)->setValue($item['qtyToRefund']);
            }
            $this->webposIndex->getOrderHistoryRefund()->getSubmitButton()->click();
            sleep(1);
            $this->webposIndex->getMsWebpos()->waitForElementVisible('.modals-wrapper');
            $this->webposIndex->getModal()->getOkButton()->click();
            sleep(1);
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="toaster"]');
            $this->assertEquals(
                'A creditmemo has been created!',
                $this->webposIndex->getToaster()->getWarningMessage()->getText(),
                'Refund success message is wrong.'
            );
            //Open notifications
            $this->webposIndex->getNotification()->getNotificationBell()->click();
            $this->assertTrue(
                $this->webposIndex->getNotification()->getFirstNotification()->isVisible(),
                'Create refund new notification haven\'t been created.'
            );
            $this->assertEquals(
                'A creditmemo has been created!',
                $this->webposIndex->getNotification()->getFirstNotificationText(),
                'Create refund notification message is wrong.'
            );
            sleep(2);
            $this->webposIndex->getNotification()->getNotificationBell()->click();
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="toaster"]');
            //Send mail
            $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="form-add-note-order"]');
            $this->webposIndex->getOrderHistoryAddOrderNote()->getSendMailButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="send-email-order"]');
            sleep(1);
            $this->webposIndex->getOrderHistorySendEmail()->getSendButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="send-email-order"]');
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="toaster"]');
            $this->assertEquals(
                'An email has been sent for this order!',
                $this->webposIndex->getToaster()->getWarningMessage()->getText(),
                'Send email success message is wrong.'
            );
            //Open notifications
            $this->webposIndex->getNotification()->getNotificationBell()->click();
            $this->assertTrue(
                $this->webposIndex->getNotification()->getFirstNotification()->isVisible(),
                'Send email new notification haven\'t been created.'
            );
            $this->assertEquals(
                'An email has been sent for this order!',
                $this->webposIndex->getNotification()->getFirstNotificationText(),
                'Send email notification message is wrong.'
            );
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="toaster"]');
            sleep(2);
            $this->webposIndex->getNotification()->getNotificationBell()->click();

            //Add comment
            $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="form-add-note-order"]');
            $this->webposIndex->getOrderHistoryAddOrderNote()->getAddCommentButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="add-comment-order"]');
            $this->webposIndex->getOrderHistoryAddComment()->getInputComment()->setValue('test comment');
            $this->webposIndex->getOrderHistoryAddComment()->getSaveButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="add-comment-order"]');
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="toaster"]');
            $this->assertEquals(
                'Add order comment successfully!',
                $this->webposIndex->getToaster()->getWarningMessage()->getText(),
                'Add order comment success message is wrong.'
            );
            //Open notifications
            $this->webposIndex->getNotification()->getNotificationBell()->click();
            $this->assertTrue(
                $this->webposIndex->getNotification()->getFirstNotification()->isVisible(),
                'Add comment new notification haven\'t been created.'
            );
            $this->assertEquals(
                'Add order comment successfully!',
                $this->webposIndex->getNotification()->getFirstNotificationText(),
                'Add comment notification message is wrong.'
            );
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="toaster"]');
            sleep(2);
            $this->webposIndex->getNotification()->getNotificationBell()->click();

            //Reorder
            $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="form-add-note-order"]');
            $this->webposIndex->getOrderHistoryAddOrderNote()->getReOrderButton()->click();
            sleep(1);
            foreach ($products as $item) {
                $productName = $item['product']->getName();
                $this->assertTrue(
                    $this->webposIndex->getCheckoutCartItems()->getCartItem($productName)->isVisible(),
                    'Product ' . $productName . ' is not available in cart.'
                );
            }
        } else {
            $this->assertTrue(
                $this->webposIndex->getOrderHistoryPayment()->getCashInMethod()->isVisible(),
                'Cash In Method - Payment Is not visible after click Take payment in Order History. Bug of Products. TestCase ID is MS64'
            );
        }
    }
}

