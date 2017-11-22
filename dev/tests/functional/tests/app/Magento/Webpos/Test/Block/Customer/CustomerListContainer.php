<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-28 08:35:14
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   Thomas
 * @Last Modified time: 2017-11-03 09:27:41
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block\Customer;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class CustomerListContainer extends Block
{
    public function searchCustomer()
    {
        return $this->_rootElement->find('//*[@id="search-header-customer"]', Locator::SELECTOR_XPATH);
    }

    public function customerSearchExist()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[1]/div/div/ul/li[1]', Locator::SELECTOR_XPATH);
    }

    public function clickAddNew()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[1]/header/nav/div/span', Locator::SELECTOR_XPATH);
    }

    protected function customerGroup()
    {
        return $this->_rootElement->find('//*[@id="form-add-customer-customer"]/div/div/div[2]/div/div[2]/div[2]/div/select', Locator::SELECTOR_XPATH);
    }

	public function getCustomerGroupSelectBox()
	{
		return $this->customerGroup();
	}

	public function getCustomerGroupItem($name)
	{
		return $this->_rootElement->find('//*[@id="form-add-customer-customer"]/div/div/div[2]/div/div[2]/div[2]/div/select/option[text()="' . $name . '"]', Locator::SELECTOR_XPATH);
	}

	public function getCustomerFirstName()
    {
        return $this->_rootElement->find('//*[@id="form-add-customer-customer"]/div/div/div[2]/div/div[1]/div[1]/div/input', Locator::SELECTOR_XPATH);
    }

	public function getCustomerLastName()
    {
        return $this->_rootElement->find('//*[@id="form-add-customer-customer"]/div/div/div[2]/div/div[1]/div[2]/div/input', Locator::SELECTOR_XPATH);
    }

	public function getCustomerEmail()
    {
        return $this->_rootElement->find('//*[@id="form-add-customer-customer"]/div/div/div[2]/div/div[2]/div[1]/div/input', Locator::SELECTOR_XPATH);
    }

    public function addValueCustomer($firstName, $lastName, $email, $group)
    {
        $this->getCustomerFirstName()->setValue($firstName);
        $this->getCustomerLastName()->setValue($lastName);
        $this->getCustomerEmail()->setValue($email);
        $this->customerGroup()->click();
        $this->_rootElement->find('//*[@id="form-add-customer-customer"]/div/div/div[2]/div/div[2]/div[2]/div/select/option[text()="' . $group . '"]', Locator::SELECTOR_XPATH)->click();
    }

    protected function isCheckedSubcribe()
    {
        return $this->_rootElement->find('#form-add-customer-customer > div > div > div.modal-body > div > div:nth-child(3) > div > div > div > div.checked');
    }

    public function subcribeNewsletter()
    {
        if ($this->isCheckedSubcribe()->isVisible()) {
        } else {
            return $this->_rootElement->find('//*[@id="form-add-customer-customer"]/div/div/div[2]/div/div[3]/div/div/div/div', Locator::SELECTOR_XPATH);
        }
    }

    public function shippingAddress()
    {
        return $this->_rootElement->find('//*[@id="form-add-customer-customer"]/div/div/div[3]/div/div[1]/div[1]/h4/span', Locator::SELECTOR_XPATH);
    }

    public function getCustomerShippingFirstName($addressType = 'shipping', $i)
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div' . $i . '/div[1]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getCustomerShippingLastName($addressType = 'shipping', $i)
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div' . $i . '/div[2]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getCustomerShippingCompany($addressType = 'shipping', $i)
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div' . $i . '/div[3]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getCustomerShippingPhone($addressType = 'shipping', $i)
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div' . $i . '/div[4]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getCustomerShippingStreet1($addressType = 'shipping', $i)
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div' . $i . '/div[5]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getCustomerShippingStreet2($addressType = 'shipping', $i)
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div' . $i . '/div[6]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getCustomerShippingCity($addressType = 'shipping', $i)
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div' . $i . '/div[7]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getCustomerShippingZipcode($addressType = 'shipping', $i)
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div' . $i . '/div[8]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getCustomerShippingCountry($addressType = 'shipping', $country)
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div[1]/div[9]/div/select/option[text()="' . $country . '"]', Locator::SELECTOR_XPATH);
    }

    public function getCustomerShippingProvince($addressType = 'shipping')
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div[1]/div[10]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getCustomerShippingVat($addressType = 'shipping', $i)
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div' . $i . '/div[11]/div/input', Locator::SELECTOR_XPATH);
    }

    protected function countryName($addressType = 'shipping')
    {
        if ($addressType == 'shipping') {
            return $this->_rootElement->find('//*[@id="form-customer-shipping-address"]/div/div/div[2]/div/div[1]/div[9]/div/select', Locator::SELECTOR_XPATH);
        } else {
            return $this->_rootElement->find('//*[@id="form-customer-billing-address"]/div/div/div[2]/div/div/div[9]/div/select', Locator::SELECTOR_XPATH);
        }
    }

    public function addValueShipping($addressType = 'shipping', $firstName, $lastName, $company, $phone, $street1, $street2, $city, $zipCode, $country, $province, $vat)
    {
        if ($addressType == 'shipping') {
            $i = '[1]';
        } else {
            $i = '';
        }

        $this->getCustomerShippingFirstName($addressType, $i)->setValue($firstName);
        $this->getCustomerShippingLastName($addressType, $i)->setValue($lastName);
        $this->getCustomerShippingCompany($addressType, $i)->setValue($company);
        $this->getCustomerShippingPhone($addressType, $i)->setValue($phone);
        $this->getCustomerShippingStreet1($addressType, $i)->setValue($street1);
        $this->getCustomerShippingStreet2($addressType, $i)->setValue($street2);
        $this->getCustomerShippingCity($addressType, $i)->setValue($city);
        $this->getCustomerShippingZipcode($addressType, $i)->setValue($zipCode);
        $this->countryName($addressType)->click();
        $this->getCustomerShippingCountry($addressType, $country)->click();
        $this->getCustomerShippingProvince($addressType)->setValue($province);
        $this->getCustomerShippingVat($addressType, $i)->setValue($vat);
    }

    public function getValueFirstNameAddress($addressType = 'shipping')
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div[1]/div[1]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getValueLastNameAddress($addressType = 'shipping')
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div[1]/div[2]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getValueCompanyAddress($addressType = 'shipping')
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div[1]/div[3]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getValuePhoneAddress($addressType = 'shipping')
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div[1]/div[4]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getValueStreetFirstAddress($addressType = 'shipping')
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div[1]/div[5]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getValueStreetSecondAddress($addressType = 'shipping')
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div[1]/div[6]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getValueCityAddress($addressType = 'shipping')
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div[1]/div[7]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getValueZipCodeAddress($addressType = 'shipping')
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div[1]/div[8]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getValueCountryAddress($addressType = 'shipping')
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div[1]/div[9]/div/select', Locator::SELECTOR_XPATH);
    }

    public function getValueProvinceAddress($addressType = 'shipping')
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div[1]/div[10]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getValueVATAddress($addressType = 'shipping')
    {
        return $this->_rootElement->find('//*[@id="form-customer-' . $addressType . '-address"]/div/div/div[2]/div/div[1]/div[11]/div/input', Locator::SELECTOR_XPATH);
    }

    protected function checkedSameAddress()
    {
        return $this->_rootElement->find('//*[@id="form-customer-shipping-address"]/div/div/div[2]/div/div[2]/div/div/label/input', Locator::SELECTOR_XPATH);
    }

    public function checkSameShippingAndBillingAddress()
    {
        if (!$this->checkedSameAddress()->isSelected()) {
            $this->checkedSameAddress()->click();
        }
    }

    public function cancelShipping()
    {
        return $this->_rootElement->find('//*[@id="form-customer-shipping-address"]/div/div/div[1]/button[1]', Locator::SELECTOR_XPATH);
    }

    public function saveShipping()
    {
        return $this->_rootElement->find('//*[@id="form-customer-shipping-address"]/div/div/div[1]/button[2]', Locator::SELECTOR_XPATH);
    }

    public function editShipping()
    {
        return $this->_rootElement->find('//*[@id="form-add-customer-customer"]/div/div/div[3]/div/div[1]/div[2]/div/div/div/div/div/a[1]/span', Locator::SELECTOR_XPATH);
    }

    public function removeShipping()
    {
        return $this->_rootElement->find('//*[@id="form-add-customer-customer"]/div/div/div[3]/div/div[1]/div[2]/div/div/div/div/div/a[2]/span', Locator::SELECTOR_XPATH);
    }

    public function cancelCustomer()
    {
        return $this->_rootElement->find('//*[@id="form-add-customer-customer"]/div/div/div[1]/button[1]', Locator::SELECTOR_XPATH);
    }

    public function saveCustomer()
    {
        return $this->_rootElement->find('//*[@id="form-add-customer-customer"]/div/div/div[1]/button[2]', Locator::SELECTOR_XPATH);
    }

    public function billingAddress()
    {
        return $this->_rootElement->find('//*[@id="form-add-customer-customer"]/div/div/div[3]/div/div[2]/div[1]/h4/a', Locator::SELECTOR_XPATH);
    }

    public function cancelBilling()
    {
        return $this->_rootElement->find('//*[@id="form-customer-billing-address"]/div/div/div[1]/button[1]', Locator::SELECTOR_XPATH);
    }

    public function saveBilling()
    {
        return $this->_rootElement->find('//*[@id="form-customer-billing-address"]/div/div/div[1]/button[2]', Locator::SELECTOR_XPATH);
    }

    public function editBilling()
    {
        return $this->_rootElement->find('//*[@id="form-add-customer-customer"]/div/div/div[3]/div/div[2]/div[2]/div/div/div/div/div/a[1]/span', Locator::SELECTOR_XPATH);
    }

    public function removeBilling()
    {
        return $this->_rootElement->find('//*[@id="form-add-customer-customer"]/div/div/div[3]/div/div[2]/div[2]/div/div/div/div/div/a[2]/span', Locator::SELECTOR_XPATH);
    }

    public function clickEditCustomerButton()
    {
        return $this->_rootElement->find('//*[@id="customer-edit-form"]/div[1]/div[1]/a', Locator::SELECTOR_XPATH);
    }

    public function editFirstName()
    {
        return $this->_rootElement->find('//*[@id="customer_firstname"]', Locator::SELECTOR_XPATH);
    }

    public function editLastName()
    {
        return $this->_rootElement->find('//*[@id="customer_lastname"]', Locator::SELECTOR_XPATH);
    }

    public function editEmail()
    {
        return $this->_rootElement->find('//*[@id="customer_email"]', Locator::SELECTOR_XPATH);
    }

    protected function clickCustomerGroup()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/main/form/div[1]/div[2]/div/div[2]/div[2]/div/select', Locator::SELECTOR_XPATH);
    }

    public function editGroup($group)
    {
        $this->clickCustomerGroup()->click();
        $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/main/form/div[1]/div[2]/div/div[2]/div[2]/div/select/option[text()="' . $group . '"]', Locator::SELECTOR_XPATH)->click();
    }

    public function saveCustomerEditted()
    {
        return $this->_rootElement->find('//*[@id="customer-edit-form"]/div[1]/div[1]/button', Locator::SELECTOR_XPATH);
    }

    public function getFirstNameShippingError()
    {
        return $this->_rootElement->find(
            '//*[@id="form-customer-shipping-address"]/div/div/div[2]/div/div[1]/div[1]/div/div', Locator::SELECTOR_XPATH);
    }

    public function getLastNameShippingError()
    {
        return $this->_rootElement->find('//*[@id="form-customer-shipping-address"]/div/div/div[2]/div/div[1]/div[2]/div/div', Locator::SELECTOR_XPATH);
    }

    public function getPhoneError()
    {
        return $this->_rootElement->find('//*[@id="form-customer-shipping-address"]/div/div/div[2]/div/div[1]/div[4]/div/input', Locator::SELECTOR_XPATH);
    }

    public function getStreetError()
    {
        return $this->_rootElement->find('//*[@id="form-customer-shipping-address"]/div/div/div[2]/div/div[1]/div[5]/div/div', Locator::SELECTOR_XPATH);
    }

    public function getCityError()
    {
        return $this->_rootElement->find('//*[@id="form-customer-shipping-address"]/div/div/div[2]/div/div[1]/div[7]/div/div', Locator::SELECTOR_XPATH);
    }

    public function getZipCodeError()
    {
        return $this->_rootElement->find(
            '//*[@id="form-customer-shipping-address"]/div/div/div[2]/div/div[1]/div[7]/div/div', Locator::SELECTOR_XPATH);
    }

    public function getCountryError()
    {
        return $this->_rootElement->find('//*[@id="form-customer-shipping-address"]/div/div/div[2]/div/div[1]/div[9]/div/div', Locator::SELECTOR_XPATH);
    }

    public function getFirstNameBillingError()
    {
        return $this->_rootElement->find('//*[@id="form-customer-billing-address"]/div/div/div[2]/div/div/div[1]/div/div', Locator::SELECTOR_XPATH);
    }

    public function getLastNameBillingError()
    {
        return $this->_rootElement->find('//*[@id="form-customer-billing-address"]/div/div/div[2]/div/div/div[2]/div/div', Locator::SELECTOR_XPATH);
    }

    public function getPhoneBillingError()
    {
        return $this->_rootElement->find('//*[@id="form-customer-billing-address"]/div/div/div[2]/div/div/div[4]/div/div', Locator::SELECTOR_XPATH);
    }

    public function getStreetBillingError()
    {
        return $this->_rootElement->find('//*[@id="form-customer-billing-address"]/div/div/div[2]/div/div/div[5]/div/div', Locator::SELECTOR_XPATH);
    }

    public function getCityBillingError()
    {
        return $this->_rootElement->find('//*[@id="form-customer-billing-address"]/div/div/div[2]/div/div/div[7]/div/div', Locator::SELECTOR_XPATH);
    }

    public function getZipCodeBillingError()
    {
        return $this->_rootElement->find('//*[@id="form-customer-billing-address"]/div/div/div[2]/div/div/div[8]/div/div', Locator::SELECTOR_XPATH);
    }

    public function getCountryBillingError()
    {
        return $this->_rootElement->find('//*[@id="form-customer-billing-address"]/div/div/div[2]/div/div/div[9]/div/div', Locator::SELECTOR_XPATH);
    }

    public function getFirstNameError()
    {
        return $this->_rootElement->find('#first-name-error');
    }

    public function getLastNameError()
    {
        return $this->_rootElement->find('#last-name-error');
    }

    public function getEmailError()
    {
        return $this->_rootElement->find('#email-error');
    }

    public function getGroupCustomerError()
    {
        return $this->_rootElement->find('#customer_group-error');
    }

    public function getInforFirstNameError()
    {
        return $this->_rootElement->find('#customer_firstname-error');
    }

    public function getInforLastNameError()
    {
        return $this->_rootElement->find('#customer_lastname-error');
    }

    public function getInforEmailError()
    {
        return $this->_rootElement->find('#customer_email-error');
    }

    public function getInforGroupCustomerError()
    {
        return $this->_rootElement->find('#customer_group-error');
    }

    public function clickAddAddress()
    {
        return $this->_rootElement->find('//*[@id="customer-edit-form"]/div[2]/div[1]/a', Locator::SELECTOR_XPATH);
    }

    public function addCompanyCustomer()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/form[1]/div/div/div[2]/div/div[2]/div[1]/div/input', Locator::SELECTOR_XPATH);
    }

    public function addPhoneCustomer()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/form[1]/div/div/div[2]/div/div[2]/div[2]/div/input', Locator::SELECTOR_XPATH);
    }

    public function addStreet1Customer()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/form[1]/div/div/div[2]/div/div[3]/div[1]/div/input', Locator::SELECTOR_XPATH);
    }

    public function addStreet2Customer()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/form[1]/div/div/div[2]/div/div[3]/div[2]/div/input', Locator::SELECTOR_XPATH);
    }

    public function addCityCustomer()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/form[1]/div/div/div[2]/div/div[4]/div[1]/div/input', Locator::SELECTOR_XPATH);
    }

    public function addZipCodeCustomer()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/form[1]/div/div/div[2]/div/div[4]/div[2]/div/input', Locator::SELECTOR_XPATH);
    }

    public function clickAddCountry()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/form[1]/div/div/div[2]/div/div[5]/div[1]/div/select', Locator::SELECTOR_XPATH);
    }

	public function getCountryItem($country)
	{
		return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/form[1]/div/div/div[2]/div/div[5]/div[1]/div/select/option[text()="' . $country . '"]', Locator::SELECTOR_XPATH);
	}

    public function addCountryCustomer($country)
    {
        $this->clickAddCountry()->click();
        $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/form[1]/div/div/div[2]/div/div[5]/div[1]/div/select/option[text()="' . $country . '"]', Locator::SELECTOR_XPATH)->click();
    }

    public function addProvinceCustomer()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/form[1]/div/div/div[2]/div/div[5]/div[2]/div/input', Locator::SELECTOR_XPATH);
    }

    public function addVATCustomer()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/form[1]/div/div/div[2]/div/div[6]/div/div/input', Locator::SELECTOR_XPATH);
    }

    public function addAddressCustomer($company, $phone, $street1, $street2, $city, $zipCode, $country, $province, $vat)
    {
        $this->addCompanyCustomer()->setValue($company);
        $this->addPhoneCustomer()->setValue($phone);
        $this->addStreet1Customer()->setValue($street1);
        $this->addStreet2Customer()->setValue($street2);
        $this->addCityCustomer()->setValue($city);
        $this->addZipCodeCustomer()->setValue($zipCode);
        $this->addCountryCustomer($country);
        $this->addProvinceCustomer()->setValue($province);
        $this->addVATCustomer()->setValue($vat);
        $this->clickSaveAddressCustomer()->click();
    }

    public function getCancelCustomerAddress()
    {
        return $this->_rootElement->find('#form-customer-add-address > div > div > div.popup-header > button.close');
    }

    public function getCustomerAddressForm()
    {
        return $this->_rootElement->find('#form-customer-add-address');
    }

    public function clickSaveAddressCustomer()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/form[1]/div/div/div[1]/button[2]', Locator::SELECTOR_XPATH);
    }

    public function getCustomerFirstNameError()
    {
        return $this->_rootElement->find('#first-name-error');
    }

    public function getCustomerLastNameError()
    {
        return $this->_rootElement->find('#last-name-error');
    }

    public function getCustomerPhoneError()
    {
        return $this->_rootElement->find('#phone-error');
    }

    public function getCustomerStreetError()
    {
        return $this->_rootElement->find('#street1-error');
    }

    public function getCustomerCityError()
    {
        return $this->_rootElement->find('#city-error');
    }

    public function getCustomerZipcodeError()
    {
        return $this->_rootElement->find('#zipcode-error');
    }

    public function getCustomerCountryError()
    {
        return $this->_rootElement->find('#country_id-error');
    }

    public function closeCustomerPopupForm()
    {
        return $this->_rootElement->find('.close');
    }

    public function editCustomerAddress()
    {
        return $this->_rootElement->find('#customer-edit-form > div:nth-child(2) > div.panel-body > div > div:last-child > div > a.edit-address > span');
    }

    public function clickAddComplain()
    {
        return $this->_rootElement->find('//*[@id="customer-edit-form"]/div[5]/div[1]/a', Locator::SELECTOR_XPATH);
    }

    public function getFormCustomerComplain()
    {
        return $this->_rootElement->find('#form-add-customer-complain');
    }

    public function addComplainValue()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/form[5]/div/div/div[2]/div/div/div/textarea', Locator::SELECTOR_XPATH);
    }

    public function saveCustomerComplain()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/form[5]/div/div/div[1]/button[2]', Locator::SELECTOR_XPATH);
    }

    public function closeCustomerComplain()
    {
        return $this->_rootElement->find('//*[@id="customer_list_container"]/div[1]/div[2]/form[5]/div/div/div[1]/button[1]', Locator::SELECTOR_XPATH);
    }

    public function getComplainError()
    {
        return $this->_rootElement->find('#complain-form-error');
    }

    public function useToCheckout()
    {
        return $this->_rootElement->find('.use-to-checkout');
    }

	// Get Customer Info
	public function getFirstCustomer()
	{
		return $this->_rootElement->find('.list-customer .product-item .item');
	}

	public function getFirstName()
	{
		return $this->_rootElement->find('#customer-edit-form > div:nth-child(1) > div.panel-body > div > div:nth-child(1) > div.customer-fname.customer-info > span');
	}

	public function getLastName()
	{
		return $this->_rootElement->find('#customer-edit-form > div:nth-child(1) > div.panel-body > div > div:nth-child(1) > div.customer-lname.customer-info > span');
	}

	public function getEmail()
	{
		return $this->_rootElement->find('#customer-edit-form > div:nth-child(1) > div.panel-body > div > div:nth-child(2) > div.customer-email.customer-info > span');
	}

	public function getCustomerGroup()
	{
		return $this->_rootElement->find('#customer-edit-form > div:nth-child(1) > div.panel-body > div > div:nth-child(2) > div.customer-group.customer-info > span');
	}

	public function customerComplainIsVisible($complain)
	{
		return $this->_rootElement->find('//*[@id="customer-edit-form"]/div[5]/div[2]/table/tbody/tr/td[text()="'.$complain.'"]', Locator::SELECTOR_XPATH)->isVisible();
	}
}
