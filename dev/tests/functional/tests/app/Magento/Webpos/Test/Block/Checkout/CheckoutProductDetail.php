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

    public function waitForAvailableQtyVisible(){
        return $this->waitForElementVisible('span[data-bind="text: childQty"]');
    }

    public function selectAttributes($label, $option){
        $this->_rootElement->find('//*[@id="product-options-wrapper"]/div[2]/div/label/span[text()="'.$label.'"]/../../div/select', Locator::SELECTOR_XPATH, 'select')->setValue($option);
    }
}