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
 * Class WebposOnHoldOrderONH09Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\HoldOrder
 */
class WebposOnHoldOrderONH09Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject
    (
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

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
        $this->webposIndex->getCheckoutProductEdit()->getDollarButton()->click();
        $this->webposIndex->getCheckoutProductEdit()->getAmountInput()->setValue($priceCustom);
        $this->webposIndex->getMainContent()->waitForMsWebpos();
        $this->webposIndex->getMsWebpos()->clickOutsidePopup();
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