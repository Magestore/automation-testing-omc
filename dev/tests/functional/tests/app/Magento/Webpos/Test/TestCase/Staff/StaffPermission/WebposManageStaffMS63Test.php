<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/7/2018
 * Time: 8:51 AM
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
 * Class WebposManageStaffMS63Test
 * @package Magento\Webpos\Test\TestCase\Staff\StaffPermission
 */
class WebposManageStaffMS63Test extends Injectable
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
    ) {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'staff_ms61']);
        return ['staffData' => $staff->getData()];
    }

    /**
     * Create WebposRole group test.
     *
     * @param WebposRole
     * @return void
     */
    public function test(WebposRole $webposRole, $products, $staffData)
    {
        //Create role and staff for role
        /**@var Location $location*/
        $location = $this->fixtureFactory->createByCode('location', ['dataset' => 'default']);
        $location->persist();
        $locationId = $location->getLocationId();
        $posData['pos_name'] = 'Pos Test %isolation%';
        $posData['status'] = 'Enabled';
        $array = [];
        $array[] = $locationId;
        $posData['location_id'] = $array;
        /**@var Pos $pos*/
        $pos = $this->fixtureFactory->createByCode('pos', ['data' => $posData]);
        $pos->persist();
        $posId = $pos->getPosId();
        $array = [];
        $array[] = $locationId;
        $staffData['location_id'] = $array;
        $array = [];
        $array[] = $posId;
        $staffData['pos_ids'] = $array;
        /**@var Staff $staff*/
        $staff = $this->fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff->persist();
        $roleData = $webposRole->getData();
        $array = [];
        $array[] = $staff->getStaffId();
        $roleData['staff_id'] = $array;
        $role = $this->fixtureFactory->createByCode('webposRole', ['data' => $roleData]);
        $role->persist();
        //Create product
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        //Login
        $this->login($staff);
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
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => true,
                'shipped' => true
            ]
        )->run();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="toaster"]');
        // Go to orders history
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        sleep(2);
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        //Send mail
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="form-add-note-order"]');
        $this->webposIndex->getOrderHistoryAddOrderNote()->getSendMailButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="send-email-order"]');
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

    }

    /**
     * @param Staff $staff
     */
    public function login(Staff $staff)
    {
        $username = $staff->getUsername();
        $password = $staff->getPassword();
        $this->webposIndex->open();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
        if ($this->webposIndex->getLoginForm()->isVisible()) {
            $this->webposIndex->getLoginForm()->getUsernameField()->setValue($username);
            $this->webposIndex->getLoginForm()->getPasswordField()->setValue($password);
            $this->webposIndex->getLoginForm()->clickLoginButton();
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
            sleep(2);
            $this->webposIndex->getMsWebpos()->waitForSyncDataVisible();
            $time = time();
            $timeAfter = $time + 360;
            while ($this->webposIndex->getFirstScreen()->isVisible() && $time < $timeAfter){
                $time = time();
            }
            sleep(2);
        }
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

    }

}

