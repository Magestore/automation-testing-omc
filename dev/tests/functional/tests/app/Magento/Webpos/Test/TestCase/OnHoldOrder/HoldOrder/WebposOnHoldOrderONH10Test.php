<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 13:26
 */

namespace Magento\Webpos\Test\TestCase\OnHoldOrder\HoldOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOnHoldOrderONH10Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\HoldOrder
 * Precondition and setup steps:
 * 1. Login Webpos as a staff
 * 2. Add a product
 * 3.  Click to product name > Discount tab > Input amount: 10%
 * 4. Hold order successfully
 * Steps:
 * 1. Click on On-Hold Orders menu
 * Acceptance Criteria:
 * "A new on-hold order is created with:
 * + [Original Price] = Original price of that product
 * + [Price] = [Original price] - [Original] x 10%
 * + [Subtotal] = Price x Qty"
 */
class WebposOnHoldOrderONH10Test extends Injectable
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
     * @param $priceCustom
     * @return array
     */
    public function test($products, $priceCustom)
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
        //Click to product name > Discount tab > Input amount less than original
        $this->webposIndex->getCheckoutCartItems()->getFirstCartItem()->click();
        $this->webposIndex->getCheckoutProductEdit()->getDiscountButton()->click();
        $this->webposIndex->getCheckoutProductEdit()->getPercentButton()->click();
        $this->webposIndex->getCheckoutProductEdit()->getAmountInput()->setValue($priceCustom);
        sleep(1);
        $this->webposIndex->getCheckoutProductEdit()->getClosePopupCustomerSale()->click();
        sleep(2);
        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        $dataProduct = $product->getData();
        $dataProduct['qty'] = 1;
        return ['product' => $dataProduct];
    }
}