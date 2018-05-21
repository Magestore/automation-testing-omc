<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 3/8/2018
 * Time: 10:38 PM
 */

namespace Magento\Webpos\Test\TestCase\Staff\StaffPermission;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebposManageStaffMS74Test
 * @package Magento\Webpos\Test\TestCase\Staff\StaffPermission
 */
class WebposManageStaffMS74Test extends Injectable
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
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    /**
     * Inject WebposIndex pages.
     *
     * @param $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    ) {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
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
        //LoginTest
        $this->login($staff);
        // Add product to cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AddProductToCartStep',
            ['products' => $products]
        )->run();
        $totalBefore = $this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Total')->getText();
        $totalBefore = (float)(substr($totalBefore, '1'));
        //Add discount to product
        $this->webposIndex->getCheckoutCartItems()->getFirstCartItem()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-edit-product"]');
        sleep(1);
        $this->webposIndex->getCheckoutProductEdit()->getDiscountButton()->click();
        sleep(1);
        $this->webposIndex->getCheckoutProductEdit()->getAmountInput()->setValue(69);
        $this->webposIndex->getMainContent()->waitForMsWebpos();
        $this->webposIndex->getMsWebpos()->clickOutsidePopup();
        sleep(1);
//        sleep(2);
        $totalAfter = $this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Total')->getText();
        $totalAfter = (float)(substr($totalAfter, '1'));
        $this->assertNotEquals(
            $totalBefore,
            $totalAfter,
            'Total not change after add discount.'
        );
        // Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(3);
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue(0);
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="toaster"]');
        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
        //End Assert Place Order Success
        $orderId = str_replace('#' , '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());
        //Go to Orders History
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        sleep(2);
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        $this->assertEquals(
            $orderId,
            $this->webposIndex->getOrderHistoryOrderList()->getFirstOrderId()->getText(),
            'Order has not save to Orders History.'
        );

    }

    public function login(Staff $staff, Location $location = null, Pos $pos = null)
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
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="webpos-location"]');
            if ($location) {
                $this->webposIndex->getLoginForm()->setLocation($location->getDisplayName());
            }
            if ($pos) {
                $this->webposIndex->getLoginForm()->setPos($pos->getPosName());
            }
            if ($location || $pos) {
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

    }

}

