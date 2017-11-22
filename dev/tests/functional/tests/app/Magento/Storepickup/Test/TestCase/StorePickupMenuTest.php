<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 11/22/2017
 * Time: 1:43 PM
 */

namespace Magento\Storepickup\Test\TestCase;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\TestCase\Injectable;
use Magento\Backend\Test\Page\Adminhtml\Dashboard;

/**
 * Steps:
 * 1. Log in as default admin user.
 * 2. Go to Rewardpoints > Earning Rates.
 * 3. Press "Add New Earning Rate" button.
 * 4. Fill form.
 * 5. Click "Save Earning Rate" button.
 * 6. Perform all assertions.
 */
class StorePickupMenuTest extends Injectable
{

    public function test(Dashboard $dashboard, $menuItem, $waitMenuItemNotVisible = true)
    {
        $dashboard->open();
        $dashboard->getMenuBlock()->navigate($menuItem, $waitMenuItemNotVisible);
    }

}