<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 05/12/2017
 * Time: 14:07
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Locations\Edit;

use Magento\Mtf\Block\Form;
use Magento\Mtf\Client\Locator;

class LocationsForm extends Form
{
    public function getField($id)
    {
        $id = '#' . $id;
        return $this->_rootElement->find($id);
    }

    public function getMessageRequired($id)
    {
        return $this->_rootElement->find('#' . $id)->getText();
    }

    public function isMessageRequiredDisplay($id)
    {
        return $this->_rootElement->find('#' . $id);
    }

    public function getLocationName()
    {
        return $this->_rootElement->find('#page_display_name')->getValue();
    }

    public function setLocationName($displayName)
    {
        $this->_rootElement->find('#page_display_name')->setValue($displayName);
    }

    public function getAddress()
    {
        return $this->_rootElement->find('#page_address')->getValue();
    }

    public function setAddress($address)
    {
        $this->_rootElement->find('#page_address')->setValue($address);
    }

    public function getDescription()
    {
        return $this->_rootElement->find('#page_description')->getValue();
    }

    public function setDescription($description)
    {
        $this->_rootElement->find('#page_description')->setValue($description);
    }

    public function getStoreView()
    {
        $value = $this->_rootElement->find('#page_store_id')->getValue();
        if ($value == null)
            return '';
        return $this->_rootElement->find('#page_store_id')->find('[value="' . $value . '"]')->getText();
    }

    public function getFieldByName($name)
    {
        return $this->_rootElement->find('//form[@id = "edit_form"]//label//span[text()="'.$name.'"]', locator::SELECTOR_XPATH);
    }
}
