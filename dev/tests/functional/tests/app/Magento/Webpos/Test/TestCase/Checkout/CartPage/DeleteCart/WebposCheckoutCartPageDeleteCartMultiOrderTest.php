<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/12/2017
 * Time: 15:01
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\DeleteCart;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertFirstCartIsRemains
 *
 * Precondition: 1. LoginTest Webpos as a staff
 * Steps: "1. Click on (+) add multi order icon
2. Add a product to 1st cart
3. Add a product to 2nd cart
4. Click on Delete icon of 2nd cart"
 * Accept: "1. Product in 2nd card is removed
2. Product in 1st remains"
 *
 * @package Magento\Webpos\Test\Constraint\Cart\CartPage\DeleteCart
 */
class WebposCheckoutCartPageDeleteCartMultiOrderTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(
		CatalogProductSimple $product
	)
	{
		// LoginTest webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();

		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

		$this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();

		//Add Product to Order 1
		$this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem(1)->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

		$this->webposIndex->getCheckoutProductList()->search($product->getName());
		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		// Add Product to Order 2
		$this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem(2)->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

		$this->webposIndex->getCheckoutProductList()->search($product->getName());
		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

		sleep(1);
		$this->webposIndex->getCheckoutCartHeader()->getIconDeleteCart()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
	}
}