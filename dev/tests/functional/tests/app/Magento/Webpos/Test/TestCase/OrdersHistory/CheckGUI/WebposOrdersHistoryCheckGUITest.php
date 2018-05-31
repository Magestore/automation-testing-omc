<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/24/2018
 * Time: 9:06 AM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOrdersHistoryCheckGUITest
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\CheckGUI
 * Precondition and setup steps:
 * Login Webpos as a staff
 * Steps:
 * Click on Orders History menu
 * Acceptance Criteria:
 * Redirect to Orders History page including:
 * - Order list is shown on the left
 * - Order detail is shown on the right"
 */
class WebposOrdersHistoryCheckGUITest extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(WebposIndex $webposIndex)
    {
        $this->webposIndex = $webposIndex;
    }

    public function test()
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        // Go to orders history
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
    }
}