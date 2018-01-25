<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:08
 */

namespace Magento\Webpos\Test\Block\Checkout;
use Magento\GroupedProduct\Test\Fixture\GroupedProduct;
use Magento\Mtf\Client\Locator;
use Magento\Mtf\Block\Block;
use Magento\Mtf\Fixture\FixtureInterface;

/**
 * Class CheckoutProductDetail
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Block\CategoryRepository
 */
class CheckoutProductDetail extends Block
{
    protected $subProductByName = './/tr[./td[contains(@class,"item")] and .//*[contains(.,"%s")]]';

    protected $qty = '[name^="super_group"]';

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

    public function waitForAvailableQtyVisible(){
        return $this->waitForElementVisible('span[data-bind="text: childQty"]');
    }

    public function selectAttributes($label, $option){
        $this->_rootElement->find('//*[@id="product-options-wrapper"]/div[2]/div/label/span[text()="'.$label.'"]/../../div/select', Locator::SELECTOR_XPATH, 'select')->setValue($option);
    }

    public function fillGroupedProductQty(FixtureInterface $product)
    {
        /** @var GroupedProduct $product */
        $associatedProducts = $product->getAssociated()['products'];
        $checkoutData = $product->getCheckoutData();
        if (isset($checkoutData['options'])) {
            // Replace link key to label
            foreach ($checkoutData['options'] as $key => $productData) {
                $productKey = str_replace('product_key_', '', $productData['name']);
                $checkoutData['options'][$key]['name'] = $associatedProducts[$productKey]->getName();
            }

            // Fill
            foreach ($checkoutData['options'] as $productData) {
                $subProduct = $this->_rootElement->find(
                    sprintf($this->subProductByName, $productData['name']),
                    Locator::SELECTOR_XPATH
                );
                $subProduct->find($this->qty)->setValue($productData['qty']);
                $this->_rootElement->click();
            }
        }
    }
}