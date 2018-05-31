<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 18/01/2018
 * Time: 09:19
 */

namespace Magento\Webpos\Test\TestCase\Tax\ApplyTaxToFPTYes;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountOnCartPageAndCheckoutPageWithTaxApplyToFPT;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Setting: Setting: [Apply Tax To FPT] = Yes
 * Testcase TAX97 - Check tax amount on cart page and Checkout page
 *
 * Precondition:
 * In backend:
 * 1. Go to Configuration >Sales >Tax >Fixed Product Taxes:
 * -  Setting: http://docs.magento.com/m2/ce/user_guide/tax/fixed-product-tax-configuration.html
 * - [Apply Tax To FPT] = Yes
 * - Other fields: tick on [Use system value]
 * 2. Save config
 * On webpos:
 * 1. Login Webpos as a staff
 *
 * Steps
 * 1. Add a  product and select a customer to meet FTP tax
 * 2. Check tax amount
 * 3. Click on [Checkout] button
 * 4. Check tax amount on Checkout page
 * 5. Place order
 *
 * Acceptance Criteria
 * 2.
 * Tax amount = [product_price_excl_tax] * [tax_rate] + [fixed_product_tax] * [tax_rate]
 * 4. Tax amount is changless
 * 5. Place order successfully
 *
 * Class WebposTaxTAX97Test
 * @package Magento\Webpos\Test\TestCase\Tax\ApplyTaxToFPTYes
 */
class WebposTaxTAX97Test extends Injectable
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
     * @var AssertTaxAmountOnCartPageAndCheckoutPageWithTaxApplyToFPT
     */
    protected $assertTaxAmountOnCartPageAndCheckoutPageWithTaxApplyToFPT;

    /**
     * Prepare data.
     *
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'johndoe_MI_unique_first_name']);
        $customer->persist();

        $taxRate = $fixtureFactory->createByCode('taxRate', ['dataset' => 'US-MI-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($taxRate);

        // Config: use system value for all field in Tax Config
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_tax_configuration_use_system_value']
        )->run();

        return [
            'customer' => $customer,
            'taxRate' => $taxRate->getRate()
        ];
    }

    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertTaxAmountOnCartPageAndCheckoutPageWithTaxApplyToFPT $assertTaxAmountOnCartPageAndCheckoutPageWithTaxApplyToFPT
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertTaxAmountOnCartPageAndCheckoutPageWithTaxApplyToFPT = $assertTaxAmountOnCartPageAndCheckoutPageWithTaxApplyToFPT;
    }

    public function test(
        Customer $customer,
        $taxRate,
        $products,
        $configData,
        $createInvoice = true,
        $shipped = false
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

        sleep(5);

        // Assert Tax on Checkout
        $this->assertTaxAmountOnCartPageAndCheckoutPageWithTaxApplyToFPT->processAssert($taxRate, $products, $this->webposIndex);

        // Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        sleep(3);

        // Assert Tax on Checkout
        $this->assertTaxAmountOnCartPageAndCheckoutPageWithTaxApplyToFPT->processAssert($taxRate, $products, $this->webposIndex);

        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => $createInvoice,
                'shipped' => $shipped
            ]
        )->run();

        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        return [
            'products' => $products
        ];
    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_tax_configuration_use_system_value']
        )->run();
    }
}