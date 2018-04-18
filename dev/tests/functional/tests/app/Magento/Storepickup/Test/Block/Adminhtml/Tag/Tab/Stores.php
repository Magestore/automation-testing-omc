<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/6/2017
 * Time: 5:25 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Tag\Tab;

use Magento\Backend\Test\Block\Widget\Tab;
use Magento\Mtf\Client\Element\SimpleElement;

class Stores extends Tab
{
    public function setFieldsData(array $fields, SimpleElement $element = null)
    {
        $stores = (is_array($fields['storepickup_stores']['value']))
            ? $fields['storepickup_stores']['value']
            : [$fields['storepickup_stores']['value']];
        foreach ($stores as $store) {
            $this->getStoresGrid()->searchAndSelect(['store_name' => $store['name']]);
        }
    }

    public function getStoresGrid()
    {
        return $this->blockFactory->create(
            'Magento\Storepickup\Test\Block\Adminhtml\Tag\Tab\Stores\Grid',
            ['element' => $this->_rootElement->find('#storepickupadmin_store_grid')]
        );
    }
}