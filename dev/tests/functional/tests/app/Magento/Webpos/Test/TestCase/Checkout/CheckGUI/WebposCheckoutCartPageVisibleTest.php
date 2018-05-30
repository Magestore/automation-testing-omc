<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:33
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CheckGUI;

use Magento\Mtf\TestCase\Scenario;

/**
 * Class WebposMenuCheckoutCartPageVisibleTest
 * @package Magento\Webpos\Test\TestCase\CategoryRepository\CheckGUI
 *
 * Precondition:
 * 1. Login Webpos as a staff
 *
 * Steps:
 * 1. Check GUI cart page
 *
 * Acceptance:
 * Located on the right of Product grid with information:
 * - Icon:  delete cart icon, add customer icon, icon action menu "..." in the top - right of the screen, add multi order icon (+)
 * - Button: "Hold", "Checkout"
 * - Fields:
 * + Subtotal: default value = 0.00
 * + Tax: default value = 0.00
 * + Total: default value = 0.00
 * - Customer default = Guest
 *
 */
class WebposCheckoutCartPageVisibleTest extends Scenario
{
    /**
     * Runs the scenario test case
     *
     * @return void
     */
    public function test()
    {
        $this->executeScenario();
    }
}