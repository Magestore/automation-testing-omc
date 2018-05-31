<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 13:26
 */

namespace Magento\Webpos\Test\TestCase\OnHoldOrder\ProcessingOnHoldOrder;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOnHoldOrderONH18Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\ProcessingOnHoldOrder
 * Precondition and setup steps:
 * 1. Login Webpos as a staff
 * 2. Create an on-hold order successfully with customer, tax, discount whole cart, shipping fee
 * Steps:
 * 1. Go to On-Hold Orders menu
 * 2. Click on [Checkout] button on that on-hold order
 * Acceptance Criteria:
 * - Customer, tax will be loaded to cart page
 * - Discount amount whole cart, shipping fee will not be loaded to cart page
 */
class WebposOnHoldOrderONH18Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'webpos_default_guest_checkout_rollback']
        )->run();
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'have_shipping_method_on_webpos_CP195']
        )->run();
        //Create customer
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'webpos_guest_pi']);
        $customer->persist();
        return ['customer' => $customer];
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
     * @param Customer $customer
     * @param $products
     * @param $discount
     * @return array
     */
    public function test(Customer $customer, $products, $discount)
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
        //Add an exist customer
        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
        $this->webposIndex->getCheckoutChangeCustomer()->search($customer->getFirstname());
        sleep(1);
        $this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();
        sleep(1);
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        //Add a product to cart
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        //Get Tax Percent
        $taxPercent = $this->webposIndex->getCheckoutWebposCart()->getTax();

        $taxExpected = round(($product->getPrice() - $discount) * 0.085, 2);

        //Click on [Add discount] > on Discount tab, add dicount for whole cart (type: $)
        while (!$this->webposIndex->getCheckoutDiscount()->isDisplayPopup()) {
            $this->webposIndex->getCheckoutCartFooter()->getAddDiscount()->click();
        }
        $this->webposIndex->getCheckoutDiscount()->clickDiscountButton();
        $this->webposIndex->getCheckoutDiscount()->setTypeDiscount('$');
        $this->webposIndex->getCheckoutDiscount()->setNumberDiscount($discount);
        $this->webposIndex->getCheckoutDiscount()->clickDiscountApplyButton();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //Choose shipping POS
        //Cart
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $feeShippingBefore = $this->webposIndex->getCheckoutCartFooter()->getShippingPrice();
        //Choose PoS shipping method
        sleep(1);
        $this->webposIndex->getCheckoutShippingMethod()->clickPOSShipping();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        sleep(1);
        //BackToCart
        $this->webposIndex->getCheckoutWebposCart()->getIconPrevious()->click();
        sleep(2);
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
        $taxActual = $this->webposIndex->getCheckoutWebposCart()->getTax();
        $feeShippingAfter = $this->webposIndex->getCheckoutCartFooter()->getShippingPrice();
        $dataProduct = $product->getData();
        $dataProduct['qty'] = 1;
        return [
            'cartProducts' => [$dataProduct],
            'taxExpected' => $taxExpected,
            'taxActual' => $taxActual,
            'feeShippingBefore' => $feeShippingBefore,
            'feeShippingAfter' => $feeShippingAfter
        ];
    }
}