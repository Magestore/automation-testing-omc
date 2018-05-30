<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 06/12/2017
 * Time: 10:49
 */

namespace Magento\Webpos\Test\TestCase\Checkout\MultiOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCreateMultiOrderCP18Test
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\TestCase\CategoryRepository\MultiOrder
 *
 * Precondition:
 * 1. Login Webpos as a staff
 *
 * Steps:
 * 1. Click on add multi order icon (icon +)
 *
 * Acceptance:
 * "1. Open 2 carts marked number 1 and 2 with time create them.
 * 2. Focus on cart with number 2
 * 3. Add cart icon is till shown "
 *
 */
class WebposCreateMultiOrderCP18Test extends Injectable
{
    /**
     * AssertWebposCheckGUICustomerPriceCP54 Index page.
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
     * LoginTest AssertWebposCheckGUICustomerPriceCP54 group test.
     *
     * @return void
     */
    public function test($orderNumber)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        self::assertTrue(
            $this->webposIndex->getCheckoutCartHeader()->getAnyOrderItem()->isVisible(),
            'At the web pos TaxClass On the right screen. The time and number order was not visible.'
        );
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem($orderNumber)->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        self::assertTrue(
            $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->isVisible(),
            'At the web pos TaxClass On the right screen. The Button Add Multi Order was not visible.'
        );
    }
}