<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/12/2017
 * Time: 15:01
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\DeleteCart;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposMultiOrderCP25Test
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\DeleteCart
 *
 * Precondition:
 * 1. Login webpos as a staff
 * 2. Create multi order
 * 3. Logout webpos
 *
 * Steps:
 * 1. Login webpos by the same staff on step 1 of [Precondition and setup steps] column
 *
 * Acceptance:
 * Still show multi order which created on step 2 of [Precondition and setup steps] column
 *
 */
class WebposMultiOrderCP25Test extends Injectable
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

    public function test(
        CatalogProductSimple $product
    )
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        sleep(2);
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //Add Product to Order 1
        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem(1)->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        // Add Product to Order 2
        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem(2)->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        sleep(1);
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->logout();

        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
    }
}