<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/01/2018
 * Time: 16:13
 */

namespace Magento\Webpos\Test\TestCase\Tax\CheckTaxAmountWithoutShippingFeeAndDiscountAmount;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Check tax amount when ordering without shipping fee and discount amount
 * Testcase TAX12_1 - Check Tax amount when creating a partial refund
 *
 * Precondition:
 * 1. Go to backend > Configuration > Sales > Tax:
 * Setting all fields: tick on [Use system value] checkbox
 *
 * Steps
 * 1. Login webpos as a staff
 * 2. Add some  products and select a customer to meet tax condition
 * 3. Click on [Checkout] button
 * 4. On Checkout page, change the customer into other customer that doesn't meet tax conditon
 * Acceptance Criteria
 * 5. Refund successfully with exact amount
 * 6. Refund successfully
 *
 * Acceptance Criteria
 * 4. Tax amount will be update to 0
 *
 * Class WebposTaxTAX12_1Test
 * @package Magento\Webpos\Test\TestCase\Tax\CheckTaxAmountWithoutShippingFeeAndDiscountAmount
 */
class WebposTaxTAX12_1Test extends Injectable
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

        return [
            'customer' => $customer,
            'taxRate' => $taxRate->getRate()
        ];
    }

    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    public function test(
        Customer $customer,
        Customer $customer2,
        $taxRate,
        $products,
        $configData
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();

        // Config: use system value for all field in Tax Config
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $configData]
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'all_allow_shipping_for_POS']
        )->run();

        // Create Customer 2 (doesn't meet tax conditon)
        $customer2->persist();

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

        // Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        // change to another customer that doesn't meet tax conditon
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\ChangeCustomerOnCartStep',
            ['customer' => $customer2]
        )->run();
        sleep(10);

        return [
            'products' => $products
        ];
    }
}