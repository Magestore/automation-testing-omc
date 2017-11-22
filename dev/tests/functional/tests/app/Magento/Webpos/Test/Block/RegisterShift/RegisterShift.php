<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-21 09:24:23
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-25 17:02:00
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block\RegisterShift;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;
use Magento\Mtf\Client\BrowserInterface;
use Magento\Mtf\Client\ElementInterface;

class RegisterShift extends Block
{

    // Select size Product
    public function selectAddShift()
    {
        $this->_rootElement->find('//*[@id="shift_container"]/div/div[1]/header/nav/div/span', Locator::SELECTOR_XPATH)->click();
    }

    /**
     * This is a Register Shift Form
     */
    // File value to register shift
    public function registerShiftNotClose($amountValue = '$10.00', $noteText = 'I am Thomas. I am working for Magestore')
    {
        if ($this->_rootElement->find('#popup-open-shift')->isVisible()) {
            $this->_rootElement->find('//*[@id="popup-open-shift"]/div/div[2]/div[1]/div/input', Locator::SELECTOR_XPATH)->setValue($amountValue);
            $this->_rootElement->find('//*[@id="popup-open-shift"]/div/div[2]/div[1]/textarea', Locator::SELECTOR_XPATH)->setValue($noteText);
            $this->clickButtonOpenShiftDone();
        }
        sleep(3);
    }

    // Close register shift
    public function registerShiftDone()
    {
        $this->registerShiftNotClose();
        $this->finalStepToCloseRegisterShift();
    }

    // save blank register shift
    public function addBlankRegisterShift()
    {
        if ($this->_rootElement->find('#popup-open-shift')->isVisible()) {
            $this->clickButtonOpenShiftDone();
        }
        $this->finalStepToCloseRegisterShift();
    }

    // click To Close Shift
    public function clickCloseShift()
    {
        $this->_rootElement->find('//*[@id="shift_container"]/div/div[2]/footer/div/button[2]', Locator::SELECTOR_XPATH)->click();
    }

    // click to button Close Shift done
    public function clickButtonCloseShiftDone()
    {
        $this->_rootElement->find('//*[@id="popup-close-shift"]/div/div[1]/button[2]', Locator::SELECTOR_XPATH)->click();
    }

    // click to button Open Shift done
    public function clickButtonOpenShiftDone()
    {
        $this->_rootElement->find('//*[@id="popup-open-shift"]/div/div[1]/button[2]', Locator::SELECTOR_XPATH)->click();
    }

    /**
     * This is a Make Adjustment Form
     */

    // click To Make Adjustment
    public function clickMakeAdjustment()
    {
        $this->_rootElement->find('//*[@id="shift_container"]/div/div[2]/footer/div/button[1]', Locator::SELECTOR_XPATH)->click();
    }

    // add Value To Make Adjustment
    public function addValueToMakeAdjustment($action = 'add', $amountValue = '$10.00', $noteText = 'I am Thomas. I am working for Magestore. This is a Make Adjustment Form popup.')
    {
        $this->clickMakeAdjustment();
        // Check if the popup form make adjustment is visible
        if ($this->_rootElement->find('#popup-make-adjustment')->isVisible()) {
            if ($action == 'add') {
                $this->clickAddButton();
            } else if($action == 'remove') {
                $this->clickRemoveButton();
            }
            $this->_rootElement->find('//*[@id="popup-make-adjustment"]/div/div[2]/div[2]/div[1]/input', Locator::SELECTOR_XPATH)->setValue($amountValue);
            $this->_rootElement->find('//*[@id="popup-make-adjustment"]/div/div[2]/div[2]/textarea', Locator::SELECTOR_XPATH)->setValue($noteText);
            sleep(3);
        }
    }

    // click To Add Button
    public function clickAddButton()
    {
        $this->_rootElement->find('//*[@id="popup-make-adjustment"]/div/div[2]/div[1]/button[1]', Locator::SELECTOR_XPATH)->click();
    }

    // click To Remove Button
    public function clickRemoveButton()
    {
        $this->_rootElement->find('//*[@id="popup-make-adjustment"]/div/div[2]/div[1]/button[2]', Locator::SELECTOR_XPATH)->click();
    }

    // Done Make Adjustment
    public function doneMakeAdjustment()
    {
        for ($i=0; $i < 2; $i++) {
            $this->addValueToMakeAdjustment();
            sleep(3);
            $this->clickButtonCloseMakeAdjustmentDone();
        }
        $this->finalStepToCloseRegisterShift();
    }

    // File value to cancel make adjustment
    public function cancelMakeAdjustment()
    {
        $this->addValueToMakeAdjustment();
        $this->clickButtonCancelMakeAdjustment();
        $this->finalStepToCloseRegisterShift();
    }

    // Final Step to close all register shift
    protected function finalStepToCloseRegisterShift()
    {
        $this->clickCloseShift();
        $this->_rootElement->find('#popup-close-shift > div > div.modal-body > div.amount-box > div:nth-child(1) > input[type="text"]')->setValue('0');
        $this->_rootElement->find('#popup-close-shift > div > div.modal-body > div.amount-box > div:nth-child(2) > input[type="text"]')->setValue('0');
        $this->clickButtonCloseShiftDone();
    }

    // click to button Close Make Adjustment done
    public function clickButtonCloseMakeAdjustmentDone()
    {
        $this->_rootElement->find('//*[@id="popup-make-adjustment"]/div/div[1]/button[2]', Locator::SELECTOR_XPATH)->click();
    }

    // click to button Cancel Make Adjustment
    public function clickButtonCancelMakeAdjustment()
    {
        $this->_rootElement->find('//*[@id="popup-make-adjustment"]/div/div[1]/button[1]', Locator::SELECTOR_XPATH)->click();
    }

    // get Text error of make adjustment
    public function getErrorMessageAdjustment()
    {
        $this->_rootElement->find('//*[@id="popup-make-adjustment"]/div/div[2]/div[2]/div[2]/span', Locator::SELECTOR_XPATH)->getText();
    }

    // check detail ship page
    public function checkDetailShipPage($paymentMethod = '', $refund = '')
    {
        $this->_rootElement->find('//*[@id="webpos_order_list"]/div/div[2]/ul[1]/li[1]', Locator::SELECTOR_XPATH)->click();
        sleep(2);
        if ($paymentMethod == 'delivery') {
            $this->_rootElement->find('//*[@id="webpos_order_view_container"]/header/div[3]/a', Locator::SELECTOR_XPATH)->click();
            sleep(2);
            $this->_rootElement->find('//*[@id="order_payment_list_container"]/div/div[1]', Locator::SELECTOR_XPATH)->click();
            sleep(2);
            $this->_rootElement->find('//*[@id="payment_popup_form"]/div[2]/div[2]/button[2]', Locator::SELECTOR_XPATH)->click();
            sleep(2);
            $this->notifyAlert();
            sleep(5);
            $this->_rootElement->find('//*[@id="webpos_order_view_container"]/footer/div[2]/div/button[2]', Locator::SELECTOR_XPATH)->click();
            sleep(2);
            // If staff want to refund some iteam of customer aspiration
            if (!empty($refund)) {
                $this->_rootElement->find('//*[@id="orders_history_container"]/div/div[5]/div/div/form/div[2]/div[2]/table/tbody/tr[1]/td[4]/input', Locator::SELECTOR_XPATH)->setValue('0');
                sleep(3);
            }
            $this->_rootElement->find('//*[@id="invoice-popup-form"]/div[2]/div[4]/div', Locator::SELECTOR_XPATH)->click();
            sleep(2);
            $this->_rootElement->find('//*[@id="invoice-popup-form"]/div[2]/div[4]/button', Locator::SELECTOR_XPATH)->click();
            sleep(2);
            $this->notifyAlert();
        }
        $this->_rootElement->find('//*[@id="webpos_order_view_container"]/footer/div[2]/div/button', Locator::SELECTOR_XPATH)->click();
        sleep(3);
    }

    // Notify Alert
    protected function notifyAlert($action = 'yes') {
        if ($action == 'yes') {
            $this->_rootElement->find('/html/body/div[5]/aside/div[2]/footer/button[2]', Locator::SELECTOR_XPATH)->click();
        } else {
            $this->_rootElement->find('/html/body/div[5]/aside/div[2]/footer/button[1]', Locator::SELECTOR_XPATH)->click();
        }
    }


	public function getFirstShift()
	{
		return $this->_rootElement->find('.list-shifts .shift-item');
	}

	public function getTotalSales()
	{
		$value = $this->_rootElement->find('span[data-bind="text: formatPrice(shiftData().total_sales)"]')->getText();
		$value = str_replace(',', '', $value);
		return substr($value, 1);
	}

	public function getOpenedNote()
	{
		return $this->_rootElement->find('span[data-bind="text: shiftData().opened_note"]')->getText();
	}

	public function getClosedNote()
	{
		return $this->_rootElement->find('span[data-bind="text: shiftData().closed_note"]')->getText();
	}

}
