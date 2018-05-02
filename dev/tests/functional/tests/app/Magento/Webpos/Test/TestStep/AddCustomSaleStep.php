<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/01/2018
 * Time: 11:14
 */

namespace Magento\Webpos\Test\TestStep;


use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Page\WebposIndex;


/**
 * Class AddCustomSaleStep
 * @package Magento\Webpos\Test\TestStep
 */
class AddCustomSaleStep implements TestStepInterface
{

	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;


	/**
	 * @var $customProduct
	 */
	protected $customProduct;


	/**
	 * AddCustomSaleStep constructor.
	 * @param WebposIndex $webposIndex
	 * @param $customProduct
	 */
	public function __construct(
		WebposIndex $webposIndex,
		$customProduct
	)
	{
		$this->webposIndex = $webposIndex;
		$this->customProduct = $customProduct;
	}


	/**
	 * @return mixed|void
	 */
	public function run()
	{
		$random = mt_rand(1, 999999);
		$this->customProduct['name'] = str_replace('%isolation%', $random, $this->customProduct['name']);
		$this->customProduct['description'] = str_replace('%isolation%', $random, $this->customProduct['description']);

		$this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
		$this->webposIndex->getCheckoutProductList()->getCustomSaleButton()->click();
		$this->webposIndex->getCheckoutContainer()->waitForCustomSalePopup();

		$this->webposIndex->getCheckoutCustomSale()->getProductNameInput()->setValue($this->customProduct['name']);
		$this->webposIndex->getCheckoutCustomSale()->getDescriptionInput()->setValue($this->customProduct['description']);
		$this->webposIndex->getCheckoutCustomSale()->getProductPriceInput()->setValue($this->customProduct['price']);
		if ($this->customProduct['shipAble']) {
			$this->webposIndex->getCheckoutCustomSale()->getShipAbleCheckbox()->click();
		}

		$this->webposIndex->getCheckoutCustomSale()->getAddToCartButton()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
	}
}