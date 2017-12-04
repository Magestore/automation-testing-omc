<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 04/12/2017
 * Time: 13:25
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposCheckoutCartPageDeleteCartTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	public function __prepare(FixtureFactory $fixtureFactory)
	{
		$product = $fixtureFactory->createByCode(
			'catalogProductSimple',
			['dataset' => 'product_100_dollar']
		);
		$product->persist();
		return [
			'product' => $product,
		];
	}

	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(
		Staff $staff,
		CatalogProductSimple $product,
		$addProduct = true,
		$customSale = false,
		$addDiscount = false,
		$discountAmount = null
	)
	{
		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		}

		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
		if ($addProduct) {
			if (!$customSale) {
				$this->webposIndex->getCheckoutProductList()->search($product->getName());
			}
		}



	}
}