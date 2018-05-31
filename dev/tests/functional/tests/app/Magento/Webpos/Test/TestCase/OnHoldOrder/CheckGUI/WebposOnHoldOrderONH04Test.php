<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 13:44
 */

namespace Magento\Webpos\Test\TestCase\OnHoldOrder\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOnHoldOrderONH04Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\CheckGUI
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Create on-hold order successfully
 * Steps:
 * 1. Logout webpos
 * 2. Login webpos with the same account
 * 3. Go to On- hold orders page
 * Acceptance Criteria:
 * 3. No on-hold order in list
 */
class WebposOnHoldOrderONH04Test extends Injectable
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
        sleep(1);
        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

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
        sleep(1);

        //Logout webpos
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->logout();
        sleep(0.5);
        $this->webposIndex->getModal()->getOkButton()->click();
        sleep(4);
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //LoginTest webpos again
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
    }
}