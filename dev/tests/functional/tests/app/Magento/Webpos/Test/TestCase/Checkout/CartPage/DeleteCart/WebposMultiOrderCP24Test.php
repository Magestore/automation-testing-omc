<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/12/2017
 * Time: 15:01
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\DeleteCart;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposMultiOrderCP24Test
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\DeleteCart
 *
 * Precondition:
 * 1. Login Webpos as a staff
 * 2. Click on add multi order icon (icon +) to create 3 carts
 *
 * Steps:
 * 1. Click on "x" icon to delete 2nd cart
 *
 * Acceptance:
 * 1. 2nd cart is deleted
 * 2. 1st and 3rd cart are still shown
 * 3. Focus on 3rd cart
 *
 */
class WebposMultiOrderCP24Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test($number)
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        sleep(2);
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(5);
        if ($this->webposIndex->getCheckoutCartHeader()->getItemRemoveIcon($number)->isVisible()) {
            $this->webposIndex->getCheckoutCartHeader()->getItemRemoveIcon($number)->doubleClick();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            sleep(5);
        }
    }
}