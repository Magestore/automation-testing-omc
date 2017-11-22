<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-15 11:56:09
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-28 08:31:59
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class CheckoutPage extends Block
{
    public function getFirstProduct()
    {
        return $this->_rootElement->find('.product-item');
    }

	public function getFirstProductPrice()
	{
		$text = $this->_rootElement->find('#block-product-list > div > div > div > div > div:nth-child(1) > div > div.product-info > div > span')->getText();
		return substr($text, 1);
	}

    public function getFirstProductOutOfStockIcon()
    {
        return $this->_rootElement->find('#block-product-list > div > div > div > div > div:nth-child(1) > div > div.product-img > a > span');
    }

    // Click the first product in the checkout page
    public function clickFirstProduct()
    {
        $this->_rootElement->find('.product-item .product-img')->click();
    }

    // Set value to input search for adding product to cart
    public function search($string)
    {
        $this->_rootElement->find('#search-header-product')->setValue($string);
    }

    public function getProductList()
    {
        return $this->_rootElement->find('#block-product-list');
    }

    // Get Grand Total Item price value
	public function getGrandTotalItemPrice($label)
	{
		return $this->_rootElement->find('//*[@id="webpos_cart"]/div/div/div/ul/li/div[1]/label[text()="'.$label.'"]/../../div[2]/span', Locator::SELECTOR_XPATH)->getText();
	}

	public function getSubTotal()
	{
		$label = 'Subtotal';
		return $this->getGrandTotalItemPrice($label);
	}

	public function getTax()
	{
		$label = 'Tax';
		return $this->getGrandTotalItemPrice($label);
	}

	// Vincent's function
	public function getTotal2()
	{
		$label = 'Total';
		return $this->getGrandTotalItemPrice($label);
	}

	public function getTotal()
    {
        return $this->_rootElement->find('#checkout_container > div.col-sm-4.col-right > div > div > div > ul > li:nth-child(6) > div.price-box > span')->getText();
    }

    // Change Customer
	public function getChangeCustomerIcon()
	{
		return $this->_rootElement->find('#webpos_cart > header > div > span');
	}

	public function getChangeCustomerPopup()
	{
		return $this->_rootElement->find('#popup-change-customer');
	}

	public function searchCustomer($text)
	{
		$this->getChangeCustomerPopup()->find('#search-customer')->setValue($text);
	}

	public function getFirstCustomer()
	{
		return $this->getChangeCustomerPopup()->find('#popup-change-customer > div > ul > li:nth-child(1)');
	}
	// End: Change Customer

	// Add Discount
	public function getAddDiscount()
	{
		return $this->_rootElement->find('#webpos_cart > div > div > div > ul > li:nth-child(2)');
	}

	public function getAddDiscountPopup()
	{
		return $this->_rootElement->find('#webpos_cart_discountpopup');
	}

	public function clickDiscountApplyButton()
	{
		$this->getAddDiscountPopup()->find('.btn-apply')->click();
	}

    public function clickNumberButton($value)
    {
        $this->getAddDiscountPopup()->find('button[value="' . $value . '"]')->click();
    }

    public function setDiscountPercent($percent)
    {
        $this->getAddDiscountPopup()->find('#btn-percent3')->click();
        $percent = str_replace('.', '', $percent);
        for ($i = 0; $i < strlen($percent); $i++) {
            $this->clickNumberButton($percent[$i]);
        }
    }
    /////////////////

	// Add Custom Sale
	public function getCustomSaleButton()
	{
		return $this->_rootElement->find('.custom-sale');
	}

	public function getPopupCustomSale()
	{
		return $this->_rootElement->find('#popup-custom-sale');
	}

	public function getCustomSaleCalcelButton()
	{
		return $this->getPopupCustomSale()->find('button.remove');
	}

	public function getCustomSaleProductNameInput()
	{
		return $this->getPopupCustomSale()->find('input[name="name-product"]');
	}

	public function getCustomSaleProductPriceInput()
	{
		return $this->getPopupCustomSale()->find('.product-price');
	}

	public function getCustomSaleShipAbleCheckbox()
	{
		return $this->getPopupCustomSale()->find('#popup-custom-sale > div.modal-body > div > div:nth-child(2) > div > div > div');
	}

	public function getCustomSaleAddToCartButton()
	{
		return $this->getPopupCustomSale()->find('#popup-custom-sale > div.modal-body > div > div.ms-actions > button');
	}

	public function clickCustomSaleSelectTaxClass()
	{
		$this->getPopupCustomSale()->find('#popup-custom-sale > div.modal-body > div > div:nth-child(1) > div:nth-child(3) > div > select')->click();
	}

	public function getCustomSaleTaxClassItem($name)
	{
		return $this->getPopupCustomSale()->find('//*[@id="popup-custom-sale"]/div[2]/div/div[1]/div[3]/div/select/option[text()="'.$name.'"]', Locator::SELECTOR_XPATH);
	}
	//////////////////


	// Cart
	public function getEmptyCartButton()
	{
		return $this->_rootElement->find('#empty_cart');
	}

	public function getCartItem($name)
	{
		return $this->_rootElement->find('//*[@id="webpos_cart"]/div/ul/li/div/div/div/h4[text()="'.$name.'"]/../../../..', Locator::SELECTOR_XPATH);
	}

	public function getCartItemName($name)
	{
		return $this->getCartItem($name)->find('.product-name')->getText();
	}

	public function getCartItemQty($name)
	{
		return $this->getCartItem($name)->find('.number');
	}

	public function getCartItemPrice($name)
	{
		$price = $this->getCartItem($name)->find('.price')->getText();
		return substr($price, 1);
	}
	/////////////////

    // Click checkout button
    public function clickCheckoutButton()
    {
        $this->_rootElement->find('.checkout')->click();
    }

    public function clickHoldButton()
    {
        $this->_rootElement->find('.hold')->click();
    }

	// Payments
	public function getPaymentContainer()
	{
		return $this->_rootElement->find('div[data-bind="visible:showPayments"]');
	}

	public function setPaidAmount($amount)
	{
		$this->_rootElement->find('#payment_selected > div > div > div > div.input-actions > div > input[type="text"]')->setValue($amount);
	}

	public function getRemainMoney()
	{
		return $this->_rootElement->find('#webpos_checkout > footer > div > ul > li.remain-money > span');
	}

	public function getCreditCard()
    {
        return $this->_rootElement->find('.item .payment .icon-iconPOS-payment-ccforpos');
    }

	public function getCashIn()
    {
        return $this->_rootElement->find('.item .payment .icon-iconPOS-payment-cashforpos');
    }

	public function getCashOnDelivery()
    {
        return $this->_rootElement->find('.item .payment .icon-iconPOS-payment-codforpos');
    }

	// select Payment in the checkout page
	public function selectPayment($paymentMethod = 'cash')
	{
		$this->_rootElement->find('.item .payment .icon-iconPOS-payment-cashforpos')->click();
		if ($paymentMethod == 'multi') {
			$totalPrice = $this->getTotalPrice();
			$totalPrice = str_replace('$', '', $totalPrice);
			$amountValue = 0.75*$totalPrice;
			// Fill into amount box
			$this->fillAmountBox($amountValue);
			$this->_rootElement->find('#add_payment_button')->click();
			$this->_rootElement->find('//*[@id="add-more-payment"]/div/div/div[2]/div', Locator::SELECTOR_XPATH)->click();
			$this->_rootElement->find('#codforpos_reference_number')->setValue('01692804009');
		} elseif ($paymentMethod == 'delivery') {
			// Fill into amount box
			$this->fillAmountBox('0');
			$this->_rootElement->find('#add_payment_button')->click();
			$this->_rootElement->find('//*[@id="add-more-payment"]/div/div/div[2]/div/div/div', Locator::SELECTOR_XPATH)->click();
			$this->_rootElement->find('#codforpos_reference_number')->setValue('01692804009');
		}
	}

	//////////////////

    // Click Place Order
    public function clickPlaceOrder()
    {
        $this->_rootElement->find('#checkout_button')->click();
    }

	public function backToCart()
	{
		$this->_rootElement->find('#back_to_cart')->click();
	}

	public function getNotifyOrderText()
	{
		return $this->_rootElement->find('.notify-order div')->getText();
	}

	public function getOrderId()
	{
		return $this->_rootElement->find('strong[data-bind="text:getOrderIdMessage()"]')->getText();
	}

    // Click New Order Button to back the checkout page
    public function clickNewOrderButton()
    {
        $this->_rootElement->find('button[data-bind="click:startNewOrder,i18n:\'New Order\'"]')->click();
    }

    public function isCheckboxChecked($divCheckbox)
    {
        $class = $divCheckbox->find('div')->getAttribute('class');
        return strpos($class, 'checked');
    }

	public function getPaidCheckbox()
	{
		return $this->_rootElement->find('#can_paid');
	}

    // Click Mark As Shipped
    public function clickOnShippingCheckbox()
    {
        $this->_rootElement->find('#can_ship')->doubleClick();
    }

    public function clickOffShippingCheckbox()
    {
        $this->_rootElement->find('#can_ship')->doubleClick();
    }

    // Click Create Invoice
    public function clickOnCreateInvoiceCheckbox()
    {
        $this->_rootElement->find('#can_paid')->doubleClick();
    }
    public function clickOffCreateInvoiceCheckbox()
    {
        $this->_rootElement->find('#can_paid')->doubleClick();
    }

    // Click to button back to cart
    public function clickBackToCart()
    {
        $this->_rootElement->find('#back_to_cart')->click();
    }

    // Filling total in to amount box
    public function fillAmountBox($amountValue)
    {
        $this->_rootElement->find('#payment_selected .input-actions input[type="text"]')->setValue($amountValue);
    }

    // GEt Total Price
    public function getTotalPrice()
    {
        return $this->_rootElement->find('.grand-total-footer .price')->getText();
    }

    // Set discount
    public function setDiscount()
    {
        $this->_rootElement->find('.add-discount')->click();
        $this->_rootElement->find('.label-discount input[type="text"]')->setValue('Thomas');
        $this->_rootElement->find('.numberFields button:nth-child(2)')->click();
        $this->_rootElement->find('.numberFields button:nth-child(5)')->click();
        $this->_rootElement->find('.btn-apply')->click();
    }

    // Set Custom Sale
    public function setCustomSale($customerName, $productPrice)
    {
        $this->_rootElement->find('.list-product-footer .custom-sale')->click();
        $this->_rootElement->find('.wrap-custom-sale .customer-fname')->setValue($customerName);
        $this->_rootElement->find('.wrap-custom-sale .product-price')->setValue($productPrice);
        $this->_rootElement->find('.wrap-custom-sale .ms-actions')->click();
    }

    // Select size Product
    public function selectSizeProduct()
    {
        $this->_rootElement->find('//*[@id="170"]', Locator::SELECTOR_XPATH)->click();
    }

    // Is Visible Popup Product
    public function isVisiblePopupProduct()
    {
        if ($this->_rootElement->find('//*[@id="popup-product-detail"]', Locator::SELECTOR_XPATH)->isVisible()) {
            $this->selectSizeProduct();
            $this->selectColorProduct();
            $this->setQuanlity();
        }
    }

    // Select size Product
    public function selectColorProduct()
    {
        $this->_rootElement->find('//*[@id="50"]', Locator::SELECTOR_XPATH)->click();
    }

    // Select size Product
    public function setQuanlity($quanlity='1')
    {
        $this->_rootElement->find('//*[@id="product_qty"]', Locator::SELECTOR_XPATH)->setValue($quanlity);
    }

    // Select size Product
    public function addSomeProduct($products, $email='', $setDiscount='', $paymentMethod='cash', $paidOff='')
    {
        $this->clickFirstProduct();
        foreach ($products as $product) {
            $this->search($product);
        }
        sleep(2);
        $this->clickCheckoutButton();
        sleep(2);
        if (!empty($setDiscount)) {
            $this->setDiscount();
        }
        // Select Payment method
        $this->selectPayment($paymentMethod);
        // Mark as shipped on
        if (!empty($paidOff)) {
            $this->clickOffShippingCheckbox();
        } else {
            $this->clickOnShippingCheckbox();
        }
        // Double cLick vao nut Mark as shipped
        $this->clickPlaceOrder();
        sleep(2);
     // Send an email to customer
        if (!empty($email))
        {
            $this->sendEmail($email);
            // Click New Order Button
            $this->clickNewOrderButton();
            sleep(3);
        }
    }

    // Set an email to customer
    public function sendEmail($string)
    {
        $this->_rootElement->find('.form-submit-email .customer-email')->setValue($string);
        $this->clickSendEmail();
    }

    public function getCustomerEmail()
    {
        return $this->_rootElement->find('.form-submit-email .customer-email')->getValue();
    }

    // Click send an email
    public function clickSendEmail()
    {
        $this->_rootElement->find('.form-submit-email .button-actions .btn-submit')->click();
    }

    public function getShippingCheckbox()
    {
        return $this->_rootElement->find('#can_ship');
    }

    // Category
	public function getAllCategoryButton()
	{
		return $this->_rootElement->find('#product-list-wrapper > header > nav > div[data-bind="click: getAllCategories"]');
	}

	public function getAllCategoryContainer()
	{
		return $this->_rootElement->find('#all-categories');
	}

		// get Category Item (none child)
	public function getCategoryItem($name)
	{
		return $this->_rootElement->find('//*[@id="list-cat-header"]/div[1]/div/div/div/h4[text()="'.$name.'"]/..', Locator::SELECTOR_XPATH);
	}

	public function getCategoryItemName($name)
	{
		return $this->getCategoryItem($name)->find('.cat-name')->getText();
	}

	///////////////////

	public function clickShippingHeader()
	{
		$this->_rootElement->find('#checkout-method > div:nth-child(1) > div.panel-heading > h4 > a')->click();
	}

	public function getShippingMethodContainer()
	{
		return $this->_rootElement->find('#shipping-method');
	}

	public function getWebposShippingMethodRow()
	{
		return $this->_rootElement->find('//*[@id="webpos_shipping_storepickup"]/..', Locator::SELECTOR_XPATH);
	}

	public function getWebposShippingMethodName()
	{
		return $this->getWebposShippingMethodRow()->find('//label/span/em[1]', Locator::SELECTOR_XPATH)->getText();
	}

	public function getWebposShippingMethodPrice()
	{
		$price = $this->getWebposShippingMethodRow()->find('//label/span/em[2]', Locator::SELECTOR_XPATH)->getText();
		return substr($price, 1);
	}
	public function getPopUpChangeCustomer()
    {
        return $this->_rootElement->find('#popup-change-customer');
    }
}
