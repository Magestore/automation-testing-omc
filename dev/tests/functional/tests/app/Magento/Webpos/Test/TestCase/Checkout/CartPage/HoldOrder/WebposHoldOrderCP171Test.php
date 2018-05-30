<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 24/01/2018
 * Time: 21:57
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\HoldOrder;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\HoldOrder\AssertCheckOnHoldOrderEmpty;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposHoldOrderCP171Test
 * @package Magento\Webpos\Test\TestCase\Cart\CartPage\HoldOrder
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Add a product to cart
 * 3. Hold order successfully"
 *
 * Steps:
 * "1. Go to [On-hold orders] menu
 * 2. Click on [Checkout] button on that detail order
 * 3. On Checkout page, click back to cart page
 * 4. Add one more product and select customer to cart
 * 5. Click on [Hold] button again"
 *
 * Acceptance:
 * "1. The old hold order will be removed from On-hold orders
 * 2. A new hold order will be created and saved on On-hold orders"
 *
 */
class WebposHoldOrderCP171Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;
    /**
     * @var AssertCheckOnHoldOrderEmpty
     */
    protected $assertCheckEmpty;

    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'webpos_default_guest_checkout_rollback']
        )->run();

        //Create customer
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'webpos_guest_pi']);
        $customer->persist();
        return ['customer' => $customer];
    }

    public function __inject
    (
        WebposIndex $webposIndex,
        AssertCheckOnHoldOrderEmpty $assertCheckEmpty
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertCheckEmpty = $assertCheckEmpty;
    }

    public function test($products, Customer $customer)
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

        //Cart in On-Hold
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->onHoldOrders();
        sleep(1);
        $this->webposIndex->getOnHoldOrderOrderList()->getFirstOrder()->click();
        $this->webposIndex->getOnHoldOrderOrderViewFooter()->getCheckOutButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Click icon < (Back to cart)
        $this->webposIndex->getCheckoutCartHeader()->getIconBackToCart()->click();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        sleep(1);

        //Assert empty order in on-hold-order
        $this->assertCheckEmpty->processAssert($this->webposIndex);

        //Back to checkout
        sleep(1);
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->checkout();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Add more product to cart
        $this->webposIndex->getCheckoutProductList()->search($product2->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);

        //Add an exist customer
        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
        $this->webposIndex->getCheckoutChangeCustomer()->search($customer->getFirstname());
        sleep(1);
        $this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();
        sleep(1);
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //Hold
        sleep(2);
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        $dataProduct1 = $product1->getData();
        $dataProduct1['qty'] = 1;
        $dataProduct2 = $product2->getData();
        $dataProduct2['qty'] = 1;
        return ['products' => [$dataProduct1, $dataProduct2]];


    }
}