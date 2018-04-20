<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 17/01/2018
 * Time: 08:10
 */

namespace Magento\Webpos\Test\TestCase\Tax\ApplyTaxOnCustomeOriginalPriceOnly;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountOnCartPageAndCheckoutPage;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposTaxTAX92Test extends Injectable
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
		AssertTaxAmountOnCartPageAndCheckoutPage $assertTaxAmountOnCartPageAndCheckoutPage
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertTaxAmountOnCartPageAndCheckoutPage = $assertTaxAmountOnCartPageAndCheckoutPage;
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

		// Edit Custom Price Of Product
		$this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\EditCustomPriceOfProductOnCartStep',
			['products' => $products]
		)->run();

        sleep(5);

		// Assert SubTotal updated
		$subTotal = 0;
		foreach ($products as $item) {
			$subTotal += $item['customPrice'] * $item['orderQty'];
		}
		$subTotalOnPage = $this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Subtotal')->getText();
		$subTotalOnPage = (float)substr($subTotalOnPage, 1);
        $taxAmountOnHomePage = $this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Tax")->getText();
        $taxAmountOnHomePage = (float)substr($taxAmountOnHomePage,1);

		self::assertEquals(
			$subTotal,
			$subTotalOnPage,
			'Cart Page - Subtotal was not updated'
			. "\nExpected: " . $subTotal
			. "\nActual: " . $subTotalOnPage
		);
		// Assert Tax amount is correct
		$this->assertTaxAmountOnCartPageAndCheckoutPage->processAssert($taxRate, $this->webposIndex);

		// Place Order
		$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        sleep(3);
        $taxAmountOnCheckoutPage = $this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Tax")->getText();
        $taxAmountOnCheckoutPage = (float)substr($taxAmountOnCheckoutPage,1);

        \PHPUnit_Framework_Assert::assertEquals(
            $taxAmountOnHomePage,
            $taxAmountOnCheckoutPage,
            'On the Cart - The Tax is changed.'
        );
//        // Assert Tax amount is correct
//		$this->assertTaxAmountOnCartPageAndCheckoutPage->processAssert($taxRate, $this->webposIndex);

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