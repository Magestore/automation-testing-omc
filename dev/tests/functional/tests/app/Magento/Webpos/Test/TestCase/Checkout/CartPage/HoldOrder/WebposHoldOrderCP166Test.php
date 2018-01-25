<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 24/01/2018
 * Time: 21:03
 */
namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\HoldOrder;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposHoldOrderCP166Test extends Injectable
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

    public function test($products, $coupon)
    {
        //Create product
        $product = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run()[0]['product'];

        //Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Add a product to cart
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);

        //Click on [Add discount] > on Promotion tab, add a correct coupon code > Apply
        while (!$this->webposIndex->getCheckoutDiscount()->isDisplayPopup())
        {
            $this->webposIndex->getCheckoutCartFooter()->getAddDiscount()->click();
        }
        $this->webposIndex->getCheckoutDiscount()->clickPromotionButton();
        $this->webposIndex->getCheckoutDiscount()->setCouponCode($coupon);
        sleep(5);
//        $this->webposIndex->getCheckoutDiscount()->clickDiscountApplyButton();
//        $this->webposIndex->getMsWebpos()->waitCartLoader();
//        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
//        sleep(1);
//
//        //Hold
//        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
//        $this->webposIndex->getMsWebpos()->waitCartLoader();
//        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
//        sleep(1);
//
//        //Checkout in On-Hold
//        $this->webposIndex->getMsWebpos()->clickCMenuButton();
//        $this->webposIndex->getCMenu()->onHoldOrders();
//        sleep(1);
//        $this->webposIndex->getOnHoldOrderOrderList()->getFirstOrder()->click();
//        $this->webposIndex->getOnHoldOrderOrderViewFooter()->getCheckOutButton()->click();
//        $this->webposIndex->getMsWebpos()->waitCartLoader();
//        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
//        sleep(1);
//
//        $dataProduct = $product->getData();
//        $dataProduct['qty'] = 1;
//        return ['cartProducts' => [$dataProduct],
//            'type' => '$'];

    }
}