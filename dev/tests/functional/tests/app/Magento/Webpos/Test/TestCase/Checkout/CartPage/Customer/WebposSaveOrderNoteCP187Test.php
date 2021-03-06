<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 11/01/2018
 * Time: 16:18
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposSaveOrderNoteCP187Test
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Add some products  to cart
 * 3. Click on [Checkout] page"
 *
 * Steps:
 * "1. Click on action menu ""..."" on the header page
 * 2. Click on ""Add order note""
 * 3. Enter comment
 * 4. Click on ""Save"" button
 * 5. Place order "
 *
 * Acceptance:
 * "On detail order on webpos:
 * - Show content of comment in ""Comment history"" section
 * On detail order in backend:
 * - Show content of comment in ""Notes for this Order"" section"
 *
 */
class WebposSaveOrderNoteCP187Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'webpos_default_guest_checkout_rollback']
        )->run();
    }

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
     * @param $comment
     * @return array
     */
    public function test($products, $comment)
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

        //Add product to cart
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //Cart
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //Click ... Menu > click Add order note
        $this->webposIndex->getCheckoutCartHeader()->getIconActionMenu()->click();

        sleep(2);
        $this->webposIndex->getCheckoutFormAddNote()->getAddOrderNote()->click();

        sleep(2);

        //Click save button
        if ($comment != null)
            $this->webposIndex->getCheckoutNoteOrder()->getTextArea()->setValue($comment);
        $this->webposIndex->getCheckoutNoteOrder()->getSaveOrderNoteButon()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //PlaceOrder
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        sleep(1);
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        sleep(1);

        //Get orderId
        $orderId = $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText();
        $orderId = ltrim($orderId, '#');
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();

        return [
            'orderId' => $orderId
        ];
    }
}