<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 09/01/2018
 * Time: 09:28
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposPageActionMenuCP185Test
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
 * 3. Click on ""Cancel"" button"
 *
 * Acceptance:
 * Close "Order comment" popup
 *
 */
class WebposPageActionMenuCP185Test extends Injectable
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

        //Add product to cart
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //Cart
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        sleep(2);
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //Click ... Menu > click Add order note
        $this->webposIndex->getCheckoutCartHeader()->getIconActionMenu()->click();
        sleep(0.5);
        $this->webposIndex->getCheckoutFormAddNote()->waitAddOrderNote();
        sleep(0.5);
        $this->webposIndex->getCheckoutFormAddNote()->getAddOrderNote()->click();
        sleep(0.5);
        $this->webposIndex->getCheckoutNoteOrder()->waitForCloseOrderNoteButon();
        $this->webposIndex->getCheckoutNoteOrder()->getTextArea()->click();
        $this->webposIndex->getCheckoutNoteOrder()->getCloseOrderNoteButton()->click();
        sleep(2);
    }
}