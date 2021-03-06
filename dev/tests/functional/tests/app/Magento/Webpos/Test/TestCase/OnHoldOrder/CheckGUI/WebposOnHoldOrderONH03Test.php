<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 13:40
 */

namespace Magento\Webpos\Test\TestCase\OnHoldOrder\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOnHoldOrderONH03Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\CheckGUI
 * Precondition and setup steps:
 * Precondition: There are many onhold orders in On-hold orders menu (> 1 order)
 * 1. Login webpos as a staff
 * Steps:
 * 1. Click on On-hold Orders menu
 * Acceptance Criteria:
 * Show On-hold Orders page with:
 * - On-hold Order list shown on the left
 * - On-hold Order detail shown on the right
 * - Show menu icon, notification icon on the top of the left
 * - Order detail including:
 * + Show Information of selected on-hold order
 * + Buttons: Delete, Checkout
 * - On-hold order list including:
 * + List of on-hold orders with their created time, Grand total and grouped by day
 * + Textbox search
 */
class WebposOnHoldOrderONH03Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject
    (
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param $products
     * @return array
     */
    public function test($products)
    {
        //Create product
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        $product1 = $products[0]['product'];
        $product2 = $products[1]['product'];
        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        //Create a on-hold-order
        //Add a product to cart
        $this->webposIndex->getCheckoutProductList()->search($product1->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //Create more a on-hold-order
        //Add a product to cart
        $this->webposIndex->getCheckoutProductList()->search($product2->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //Click on On-hold Orders menu
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->onHoldOrders();
        $this->webposIndex->getOnHoldOrderOrderList()->waitLoader();
        sleep(1);
        $productData = $product2->getData();
        return ['products' => [$productData],
            'product' => $productData];
    }
}