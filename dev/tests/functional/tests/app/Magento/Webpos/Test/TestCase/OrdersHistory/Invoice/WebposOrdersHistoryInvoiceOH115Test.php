<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/31/2018
 * Time: 4:57 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\Invoice;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\OrderHistory\AssertOrderSuccess;

/**
 * Class WebposOrdersHistoryInvoiceOH115Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\Invoice
 */
class WebposOrdersHistoryInvoiceOH115Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertOrderSuccess
     */
    protected $assertOrderSuccess;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertOrderSuccess $assertOrderSuccess
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertOrderSuccess $assertOrderSuccess
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertOrderSuccess = $assertOrderSuccess;
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

        // Add product to cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AddProductToCartStep',
            ['products' => $products]
        )->run();

        // Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => true,
                'shipped' => true
            ]
        )->run();

        sleep(1);
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
		$orderId = $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText();
        // Assert order success
        $this->assertOrderSuccess->processAssert($this->webposIndex, $orderId);
        sleep(1);
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();


        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(1);
        $this->webposIndex->getCMenu()->ordersHistory();
        sleep(1);
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        sleep(1);
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(2);

        return [
            'products' => $products,
            'orderId' => $orderId
        ];
    }

}