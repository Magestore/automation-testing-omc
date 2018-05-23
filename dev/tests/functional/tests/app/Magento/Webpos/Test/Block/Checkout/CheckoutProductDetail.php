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

    public function getModalTitle(){
        return $this->_rootElement->find('//*[@id="popup-product-detail"]/div/div/div/div[1]/h4[@class="modal-title"]', Locator::SELECTOR_XPATH);
    }

    public function selectedOneAttribute($attribute){
        $this->_rootElement->find('.super-attribute-select',Locator::SELECTOR_CSS,'select')->setValue($attribute);
    }

    public function getButtonAddToCart(){
        return $this->_rootElement->find('#popup-product-detail > div > div > div > div.modal-body > div > div > div > div.ms-actions > button');
    }

    public function getButtonCancel(){
        return $this->_rootElement->find('//*[@id="popup-product-detail"]/div/div/div/div[1]/button[@class="close"]', Locator::SELECTOR_XPATH);
    }

	public function getProductQtyInput()
	{
		return $this->_rootElement->find('#product_qty');
	}

	public function getRadioItemOfBundleProduct($name)
	{
		return $this->_rootElement->find('//*[@id="product-options-wrapper"]/fieldset/div/div/div/div[1]/label/span[text()="'.$name.'"]/../../input', Locator::SELECTOR_XPATH);
	}

    public function getProductPriceOfOption($productName)
    {
        // Bundle product
        return $this->_rootElement->find('//*[@id="product-options-wrapper"]/fieldset/div/div/div/div/label/span[text()="'.$productName.'"]/../span[@class="price-notice"]', Locator::SELECTOR_XPATH);
    }

    public function getQtyOfOption($option)
    {
        // Bundle product
        // option = 1,2,3...
        return $this->_rootElement->find('//*[@id="product-options-wrapper"]/fieldset/div['.$option.']/div/div/div[4]/div/input', Locator::SELECTOR_XPATH);
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

    public function getGroupChildProductSpecialPrices()
    {
        $specialPriceElements = $this->_rootElement->getElements('.row-tier-price td');
        foreach ($specialPriceElements as $specialPriceElement) {
            $specialPrices[] = substr($specialPriceElement->getText(), 1);
        }
        return $specialPrices;
    }

    public function getGroupProductRowItem($productName)
    {
        $selectorTemplate = './/tr[.//strong[@class="product-item-name" and text()="%s"]]';
        $rowItemSelector = sprintf($selectorTemplate, $productName);
        return $this->_rootElement->find($rowItemSelector, Locator::SELECTOR_XPATH);
    }

    public function getGroupProductItemQtyMessageError($productName)
    {
        return $this->getGroupProductRowItem($productName)->find('//div[@class="mage-error"]', Locator::SELECTOR_XPATH);
    }

    public function getSimpleProductName()
    {
        return $this->_rootElement->find('//*[@id="popup-product-detail"]/div/div/div/div[2]/div/div[1]/div[2]/div[1]/div/div[1]/h3[@class="product-name"]', Locator::SELECTOR_XPATH);
    }

    public function getSimpleProductSKU()
    {
        return $this->_rootElement->find('//*[@id="popup-product-detail"]/div/div/div/div[2]/div/div[1]/div[2]/div[1]/div/div[1]/span[@class="sku"]', Locator::SELECTOR_XPATH);
    }

    public function getSimpleProductAvailableQty()
    {
        return $this->_rootElement->find('//*[@id="popup-product-detail"]/div/div/div/div[2]/div/div[1]/div[2]/div[1]/div/div[2]/span[@class="available_qty"]', Locator::SELECTOR_XPATH);
    }

    public function getSimpleProductPrice()
    {
        return $this->_rootElement->find('//*[@id="popup-product-detail"]/div/div/div/div[2]/div/div[1]/div[2]/div[1]/div/div[3]/div/span[@class="price"]', Locator::SELECTOR_XPATH);
    }

    public function getSimpleProductImage()
    {
        return $this->_rootElement->find('//*[@id="product-img-slise"]', Locator::SELECTOR_XPATH);
    }

    public function getButtonDownQty()
    {
        return $this->_rootElement->find('//*[@id="popup-product-detail"]/div/div/div/div[2]/div/div[1]/div[2]/div[2]/span[@class="down"]', Locator::SELECTOR_XPATH);
    }

    public function getButtonUpQty()
    {
        return $this->_rootElement->find('//*[@id="popup-product-detail"]/div/div/div/div[2]/div/div[1]/div[2]/div[2]/span[@class="up"]', Locator::SELECTOR_XPATH);
    }

    public function getSimpleProductQty()
    {
        return $this->_rootElement->find('//*[@id="product_qty"]', Locator::SELECTOR_XPATH);
    }

    public function getCancelButton()
    {
        return $this->_rootElement->find('.close');
    }

    public function getProductName()
    {
        return $this->_rootElement->find('.modal-title');
    }

    public function getConfigProductName()
    {
        return $this->_rootElement->find('.config-product .product-name');
    }

    public function getConfigProductSku()
    {
        return $this->_rootElement->find('.config-product .sku');
    }

    public function getPrice()
    {
        return $this->_rootElement->find('.price');
    }

    public function getBundleProductPrice()
    {
        return $this->_rootElement->find('//*[@id="popup-product-detail"]//span[@class="price"]', Locator::SELECTOR_XPATH);
    }

    public function getProductOptionsWrap()
    {
        return $this->_rootElement->find('[id="product-options-wrapper"]');
    }

    public function getAvailableQty()
    {
        return str_replace(' item(s)', '', $this->_rootElement->find('.available_qty')->getText());
    }

    public function getAvailability()
    {
        return $this->_rootElement->find('.availability');
    }
}