<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/01/2018
 * Time: 13:20
 */

namespace Magento\Webpos\Test\TestCase\Tax\CheckTaxAmountWithShippingFee;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 *  Check tax amount when ordering with shipping fee
 * Testcase TAX14 - Check tax amount on On-hold order
 *
 * Precondition:
 * 1. Go to backend > Configuration > Sales > Tax:
 * Setting all fields: tick on [Use system value] checkbox
 *
 * Steps
 * 1. Login webpos as a staff
 * 2. Add some  products and select a customer to meet tax condition
 * 3. Select a shipping method with fee
 * 4. Click on [Hold] button
 * 5. Go to On-hold orders page > Check tax amount
 *
 * Acceptance Criteria
 * 5.
 * - Tax amount of each product  =  (their Subtotal - Discount) x Tax rate
 * - Rowtotal of each product = their Subtotal + Tax - Discount
 * - Tax amount whole cart = SUM(tax amount of each product)
 * - Subtotal whole cart = SUM(Subtotal  of each product)
 * - Grand total = Subtotal whole cart + Shipping + Tax - Discount
 *
 *
 * Class WebposTaxTAX14Test
 * @package Magento\Webpos\Test\TestCase\Tax\CheckTaxAmountWithShippingFee
 */
class WebposTaxTAX14Test extends Injectable
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
        sleep(2);

        $this->webposIndex->getCheckoutShippingMethod()->clickShipPanel();
        $this->webposIndex->getCheckoutShippingMethod()->getFlatRateFixed()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);

        $this->webposIndex->getCheckoutWebposCart()->getIconPrevious()->click();
        sleep(1);

        $this->webposIndex->getCheckoutCartFooter()->waitButtonHoldVisible();
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->onHoldOrders();
        $this->webposIndex->getOnHoldOrderOrderList()->waitLoader();
        $this->webposIndex->getOnHoldOrderOrderList()->getFirstOrder()->click();


        return [
            'products' => $products
        ];
    }
}