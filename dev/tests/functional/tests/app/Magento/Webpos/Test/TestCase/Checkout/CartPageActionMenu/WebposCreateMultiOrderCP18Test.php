<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 06/12/2017
 * Time: 10:49
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPageActionMenu;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebposCreateMultiOrderCP18Test
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPageActionMenu
 */
class WebposCreateMultiOrderCP18Test extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * Login Webpos group test.
     *
     * @param Staff $staff
     * @return void
     */
    public function test(Staff $staff, $orderNumber)
    {
        $this->webposIndex->open();
        if ($this->webposIndex->getLoginForm()->isVisible()) {
            $this->webposIndex->getLoginForm()->fill($staff);
            $this->webposIndex->getLoginForm()->clickLoginButton();
            sleep(5);
            while ($this->webposIndex->getFirstScreen()->isVisible()) {
            }
            sleep(2);
        }
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        self::assertTrue(
            $this->webposIndex->getCheckoutCartHeader()->getAnyOrderItem()->isVisible(),
            'At the web pos Cart On the right screen. The time and number order was not visible.'
        );
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $this->webposIndex->getCheckoutWebposCart()->getOrderSequence($orderNumber)->click();
        self::assertTrue(
            $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->isVisible(),
            'At the web pos Cart On the right screen. The Button Add Multi Order was not visible.'
        );
    }
}