<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/5/2018
 * Time: 8:08 AM
 */

namespace Magento\Webpos\Test\TestCase\Tax\CheckTaxAmountWithDiscountWholeCart;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Swatches\Test\Fixture\ConfigurableProduct;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountOnCartPageAndCheckoutPage;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 *  * Preconditions:
 * 1. Create customer
 * 2. Create products
 *
 * Test Flow:
 * 1. LoginTest Web POS as staff
 * 2. Add some taxable products
 * 3. Select a customer to meet tax condition
 * 4. Add discount for whole cart
 * 5. Click "CHECKOUT" in cart page
 * 6. Check tax amount on cart page and checkout page
 *
 */

/**
 * Class WebposTaxTAX24Test
 * @package Magento\Webpos\Test\TestCase\Tax
 */
class WebposTaxTAX24Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var AssertTaxAmountOnCartPageAndCheckoutPage
     */
    protected $assertTaxAmountOnCartPageAndCheckoutPage;

    /**
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    /**
     * Prepare data.
     *
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        // Change TaxRate
        $taxRate = $fixtureFactory->createByCode('taxRate', ['dataset'=> 'US-MI-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($taxRate);

        // Add Customer
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
        $customer->persist();

        return [
            'customer' => $customer,
            'taxRate' => $taxRate->getRate()
        ];
    }

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param AssertTaxAmountOnCartPageAndCheckoutPage $assertTaxAmountOnCartPageAndCheckoutPage
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertTaxAmountOnCartPageAndCheckoutPage $assertTaxAmountOnCartPageAndCheckoutPage,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertTaxAmountOnCartPageAndCheckoutPage = $assertTaxAmountOnCartPageAndCheckoutPage;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    /**
     * @param Customer $customer
     * @param $products
     * @param $configData
     * @param $taxRate
     * @param bool $addDiscount
     * @param null $discountAmount
     * @return array
     */
    public function test(
        Customer $customer,
        $products,
        $configData,
        $taxRate,
        $addDiscount = false,
        $discountAmount = null
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();

        // Config
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $configData]
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

        // change customer
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\ChangeCustomerOnCartStep',
            ['customer' => $customer]
        )->run();

        // Add Discount
        if ($addDiscount) {
            $this->webposIndex->getCheckoutCartFooter()->getAddDiscount()->click();
            sleep(1);
            self::assertTrue(
                $this->webposIndex->getCheckoutDiscount()->isVisible(),
                'CategoryRepository - TaxClass page - Delete TaxClass - Add discount popup is not shown'
            );
            $this->webposIndex->getCheckoutDiscount()->setDiscountPercent($discountAmount);
            $this->webposIndex->getCheckoutDiscount()->clickDiscountApplyButton();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        }

        //Assert Tax Amount on Checkout Page
        $this->assertTaxAmountOnCartPageAndCheckoutPage->processAssert($taxRate, $this->webposIndex);
        //End Assert Tax Amount on Cart Page

        // Check out
        sleep(4);
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //Assert Tax Amount on Cart Page
        $this->assertTaxAmountOnCartPageAndCheckoutPage->processAssert($taxRate, $this->webposIndex);
        //End Assert Tax Amount on Cart Page

        return [
            'products' => $products,
            'taxRate' => $taxRate
        ];
    }
}