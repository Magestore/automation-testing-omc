<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/26/2018
 * Time: 4:55 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\MassActionReOrder;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OrderHistory\ReOrder\AssertItemsInCart;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposMassActionReOrderOH30Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionReOrder
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Add some products to cart
 * 3. Place order successfully
 * Steps:
 * 1. Create multi order
 * 2. Add some products to all orders
 * 3. Go to order details page
 * 4. Click on icon on the top of the right
 * 5. Click on Re-order action
 * Acceptance Criteria:
 * 1. Redirect to checkout page
 * 2. All items in the current order will be added more to current cart. The other cart is changless
 */
class WebposMassActionReOrderOH30Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory $fixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var AssertItemsInCart $assertItemsInCart
     */
    protected $assertItemsInCart;

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param AssertItemsInCart $assertItemsInCart
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertItemsInCart $assertItemsInCart
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertItemsInCart = $assertItemsInCart;
    }

    /**
     * @param $products
     * @return array
     */
    public function test(
        $products
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        // Add last product to cart
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $lastProduct = count($products) - 1;
        for ($i = 0; $i < $products[$lastProduct]['orderQty']; $i++) {
            $this->webposIndex->getCheckoutProductList()->search($products[$lastProduct]['product']->getSku());
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
        }

        // Place order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // End Place Order

        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        // Add some product to cart on order 1
        for ($k = 0; $k < count($products) - 1; $k++) {
            for ($i = 0; $i < $products[$k]['orderQty']; $i++) {
                $this->webposIndex->getCheckoutProductList()->search($products[$k]['product']->getSku());
                $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
                $this->webposIndex->getMsWebpos()->waitCartLoader();
            }
        }

        // Create multi order
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        // Add some product to cart on order 2
        for ($k = 0; $k < count($products) - 1; $k++) {
            for ($i = 0; $i < $products[$k]['orderQty']; $i++) {
                $this->webposIndex->getCheckoutProductList()->search($products[$k]['product']->getSku());
                $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
                $this->webposIndex->getMsWebpos()->waitCartLoader();
            }
        }

        // Re-order
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitForFirstOrderVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(1);
        $this->webposIndex->getOrderHistoryOrderViewHeader()->openAddOrderNote();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Re-order')->click();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();


        // Assert multi order 2
        $this->assertItemsInCart->processAssert($this->webposIndex, $products, null, false);

        // Click order 1
        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem('1')->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        sleep(2);
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $products2 = $products;
        unset($products2['2']);
        // Assert multi order 1
        $this->assertItemsInCart->processAssert($this->webposIndex, $products2, null, false);
        return [
            'products' => $products
        ];
    }
}