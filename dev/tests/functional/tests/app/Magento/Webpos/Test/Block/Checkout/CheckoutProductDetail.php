<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:08
 */

namespace Magento\Webpos\Test\Block\Checkout;
use Magento\Mtf\Client\Locator;
use Magento\Mtf\Block\Block;
/**
 * Class CheckoutProductDetail
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Block\CategoryRepository
 */
class CheckoutProductDetail extends Block
{

    public function selectedOneAttribute($attribute){
        $this->_rootElement->find('[class="super-attribute-select"]',Locator::SELECTOR_CSS,'select')->setValue($attribute);
    }

    public function getButtonAddToCart(){
        return $this->_rootElement->find('#popup-product-detail > div > div > div > div.modal-body > div > div > div > div.ms-actions > button');
    }

	public function getProductQtyInput()
	{
		return $this->_rootElement->find('#product_qty');
	}

	public function getRadioItemOfBundleProduct($name)
	{
		return $this->_rootElement->find('//*[@id="product-options-wrapper"]/fieldset/div/div/div/div[1]/label/span[text()="'.$name.'"]/../../input', Locator::SELECTOR_XPATH);
	}
}