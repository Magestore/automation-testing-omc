<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 07/12/2017
 * Time: 11:09
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Customer\Test\Fixture\Address;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebposCartPageCustomerCP34Test
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer
 */
class WebposCartPageCustomerCP34Test extends Injectable
{
	/**
	 * @var WebposIndex $webposIndex
	 */
	protected $webposIndex;

	/**
	 * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
	 */
	protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

	public function __prepare()
	{
		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => 'webpos_default_guest_checkout_rollback']
		)->run();
	}

    /**
     * @param WebposIndex $webposIndex
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
	public function __inject(
		WebposIndex $webposIndex,
		AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
	)
	{
		$this->webposIndex = $webposIndex;
		$this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
	}

    /**
     * @param CatalogProductSimple $product
     * @param Address $address
     * @return array
     */
	public function test(
		CatalogProductSimple $product,
		Address $address
	)
	{
		// LoginTest webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();

		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

		$this->webposIndex->getCheckoutProductList()->search($product->getName());
		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
		$this->webposIndex->getMsWebpos()->waitCartLoader();

		$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

		$this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
		$this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

		//Assert Place Order Success
		$this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
        sleep(2);
		$this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();

		$name = $address->getFirstname().' '.$address->getLastname();
		$addressText = $address->getCity().', '.$address->getRegionId().', '.$address->getPostcode().', ';
		$phone = $address->getTelephone();
		return [
			'name' => $name,
			'address' => $addressText,
			'phone' => $phone
		];
	}
}