<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 12/01/2018
 * Time: 10:33
 */

namespace Magento\Webpos\Test\TestCase\Tax\TaxClassForShippingTaxableGoodsAndShippingExcludingTax;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposTaxTAX37Test extends Injectable
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

		// Config: use system value for all field in Tax Config
		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => 'default_tax_configuration_use_system_value']
		)->run();

		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => 'all_allow_shipping_for_POS']
		)->run();

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

		// Place Order
		$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);

		$this->webposIndex->getCheckoutShippingMethod()->clickShipPanel();
		$this->webposIndex->getCheckoutShippingMethod()->getFlatRateFixed()->click();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

		$this->webposIndex->getCheckoutWebposCart()->getIconPrevious()->click();
		$this->webposIndex->getCheckoutCartFooter()->waitButtonHoldVisible();
        sleep(1);

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