<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/8/2018
 * Time: 1:15 PM
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
 * Staff Permission
 * Testcase MS66 - Permission
 *
 * Precondition:
 * 1. Go to backend > Sales > Manage Roles
 * 2. Add a new role
 * - Permission: Manage Inventory
 * 3. Add new staff:
 * - Select the role that create on step 2
 * - Select location
 *
 * Steps
 * 1. Login webpos by the staff who created on step 3 of [Precondition and setup steps] column
 * 2. Check permission of this staff
 *
 * Acceptance Criteria
 * 2.
 * - Show [Manage stocks] on menu
 * - Hide [Order History] tab on menu
 * - This staff is not able to add discount and edit custom price
 *
 * Class WebposManageStaffMS66Test
 * @package Magento\Webpos\Test\TestCase\Staff\StaffPermission
 */
class WebposManageStaffMS66Test extends Injectable
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
        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'staff_ms61']);
        return ['staffData' => $staff->getData()];
    }

    /**
     * Create WebposRole group test.
     *
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
        /**@var Staff $staff */
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
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff,
                'hasOpenSession' => null,
                'hasWaitOpenSessionPopup' => null
            ]
        )->run();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="c-button--push-left"]');
        $this->webposIndex->getMsWebpos()->getCMenuButton()->click();
        $this->assertTrue(
            $this->webposIndex->getCMenu()->manageStocksIsVisible(),
            'Manage Stocks on Menu is not visible.'
        );
//        $this->assertFalse(
//            $this->webposIndex->getCMenu()->ordersHistoryIsVisisble(),
//            'Orders History on Menu is not hidden.'
//        );
        $this->webposIndex->getCMenu()->checkout();
        // Add product to cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AddProductToCartStep',
            ['products' => $products]
        )->run();
        $this->assertFalse(
            $this->webposIndex->getCheckoutCartFooter()->getAddDiscount()->isVisible(),
            'Add discount function is not hidden.'
        );
        $this->webposIndex->getCheckoutCartItems()->getFirstCartItem()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-edit-product"]');
        $this->assertFalse(
            $this->webposIndex->getCheckoutProductEdit()->getCustomPriceButton()->isVisible(),
            'Custom Price button is not hidden.'
        );
        $this->assertFalse(
            $this->webposIndex->getCheckoutProductEdit()->getDiscountButton()->isVisible(),
            'Discount button is not hidden.'
        );

    }

}

