<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 15:41
 */

namespace Magento\Webpos\Test\TestCase\Setting\General;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebPOSCheckGUITabTest
 * @package Magento\Webpos\Test\TestCase\Setting\General
 * SET10 & SET11 & SET12 & SET13
 * Precondition and setup steps
 * 1. Login webpos as a staff
 *
 * SET10
 * Steps
 * 1. Click on [General] menu
 * 2. Click on [Checkout] tab
 * Acceptance Criteria
 * 2. Including some fields:
 * - Use online mode
 * - Auto check the promotion rules on checkout
 * - Sync on-hold order to server
 *
 * SET11
 * Steps
 * 1. Click on [General] menu
 * 2. Click on [Checkout] tab
 * Acceptance Criteria
 * 2. Including some fields:
 * - Use online mode
 * - Auto check the promotion rules on checkout
 * - Sync on-hold order to server
 *
 * SET12
 * Steps
 * 1. Click on [General] menu
 * 2. Click on [Currency] tab
 * Acceptance Criteria
 * 2. Including field:
 * - Currency
 *
 * SET13
 * Steps
 * 1. Click on [General] menu
 * 2. Click on [POS Hub] tab
 * Acceptance Criteria
 * 2. Including field:
 * - POS Hub IP Address
 * - Enable Open Cash Drawer Manually
 * - Manual Cashdrawer Kick Code (Leave empty for automatically)
 * - Print Via POS Hub
 * - Enable pole display
 */
class WebPOSCheckGUITabTest extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param $menuItem
     */
    public function test($menuItem)
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->general();
        sleep(1);
        $this->webposIndex->getGeneralSettingMenuLMainItem()->getMenuItem($menuItem)->click();
        sleep(1);
    }
}
