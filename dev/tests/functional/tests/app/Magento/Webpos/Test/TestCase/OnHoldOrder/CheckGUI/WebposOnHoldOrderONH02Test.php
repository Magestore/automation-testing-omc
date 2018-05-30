<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 13:26
 */

namespace Magento\Webpos\Test\TestCase\OnHoldOrder\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOnHoldOrderONH02Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\CheckGUI
 * Precondition and setup steps:
 * Precondition: There is 1 onhold order in On-hold orders menu
 * 1. Login webpos as a staff
 * Steps:
 * 1. Click on On-hold Orders menu
 * Acceptance Criteria:
 * - Show On-hold Orders page with:
 * - On-hold Order list shown on the left
 * - On-hold Order detail shown on the right
 * - Show menu icon, notification icon on the top of the left
 * - Order detail including:
 * + Information about ID, customer, shipping, billing, items and total
 * + Buttons: Delete, Checkout
 * - On-hold order list including:
 * + Textbox search with place holder ""Search by name or order ID""
 * + Order on-hold with created time, Grand total
 */
class WebposOnHoldOrderONH02Test extends Injectable
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
        $product = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run()[0]['product'];
        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        //Create a on-hold-order
        //Add a product to cart
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
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
        $productData = $product->getData();
        return ['product' => $productData];
    }
}