<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 24/01/2018
 * Time: 21:03
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\HoldOrder;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\SalesRule\Test\Fixture\SalesRule;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposHoldOrderCP166Test
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\HoldOrder
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Add a product
 * 3. Click on [Add discount] > on Promotion tab, add a correct coupon code > Apply
 * 4. Hold order successfully"
 *
 * Steps:
 * "1. Go to [On-hold orders] menu
 * 2. Click on [Checkout] button on that detail order"
 *
 * Acceptance:
 * Order will be loaded to cart page without discount then auto next to checkout page.
 *
 */
class WebposHoldOrderCP166Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __prepare(FixtureFactory $fixtureFactory)
    {
        //Create coupon
        $salesRule = $fixtureFactory->createByCode('salesRule', ['dataset' => 'active_sales_rule_with_fixed_price_discount_coupon_cp166']);
        $salesRule->persist();
        return ['salesRule' => $salesRule];
    }

    public function __inject
    (
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test($products, SalesRule $salesRule)
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

        //Add a product to cart
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);

        //Click on [Add discount] > on Promotion tab, add a correct coupon code > Apply
        while (!$this->webposIndex->getCheckoutDiscount()->isDisplayPopup()) {
            $this->webposIndex->getCheckoutCartFooter()->getAddDiscount()->click();
        }
        $this->webposIndex->getCheckoutDiscount()->clickPromotionButton();
        $coupon = $salesRule->getCouponCode();
        $this->webposIndex->getCheckoutDiscount()->setCouponCode($coupon);
        $this->webposIndex->getCheckoutDiscount()->clickCheckPromotionButton();
        sleep(4);
        $this->webposIndex->getCheckoutDiscount()->clickDiscountApplyButton();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Cart in On-Hold
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->onHoldOrders();
        sleep(1);
        $this->webposIndex->getOnHoldOrderOrderList()->getFirstOrder()->click();
        $this->webposIndex->getOnHoldOrderOrderViewFooter()->getCheckOutButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        $dataProduct = $product->getData();
        $dataProduct['qty'] = 1;
        return ['cartProducts' => [$dataProduct]];

    }
}