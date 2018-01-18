<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 18/01/2018
 * Time: 09:19
 */

namespace Magento\Webpos\Test\TestCase\Tax;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountOnCartPageAndCheckoutPageWithTaxApplyToFPT;
use Magento\Webpos\Test\Page\WebposIndex;

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

		// Login webpos
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

		// Assert Tax on Cart
		$this->assertTaxAmountOnCartPageAndCheckoutPageWithTaxApplyToFPT->processAssert($taxRate, $products, $this->webposIndex);

		// Place Order
		$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

		// Assert Tax on Cart
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