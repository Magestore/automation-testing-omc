<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 03/01/2018
 * Time: 14:50
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Page\WebposIndex;

class AddProductToCartStep implements TestStepInterface
{
	/**
	 * Webpos Index page.
	 * @var WebposIndex
	 */
	protected $webposIndex;

	protected $products;

	/**
	 * AddProductToCartStep constructor.
	 * @param WebposIndex $webposIndex
	 * @param $products
	 */
	public function __construct(
		WebposIndex $webposIndex,
		$products
	)
	{
		$this->webposIndex = $webposIndex;
		$this->products = $products;
	}

	/**
	 * @return mixed|void
	 */
	public function run()
	{
		$this->webposIndex->getCheckoutCartFooter()->waitButtonHoldVisible();
		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

		foreach ($this->products as $item) {
			for ($i = 0; $i < $item['orderQty']; $i++) {
                $this->webposIndex->getCheckoutProductList()->search($item['product']->getSku());
                $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
                $this->webposIndex->getMsWebpos()->waitCartLoader();
				sleep(1);
            }
		}
	}
}