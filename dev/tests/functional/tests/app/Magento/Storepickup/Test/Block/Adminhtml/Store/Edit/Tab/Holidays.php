<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/8/2017
 * Time: 10:15 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Store\Edit\Tab;

use Magento\Backend\Test\Block\Widget\Tab;
use Magento\Mtf\Client\Element\SimpleElement;

class Holidays extends Tab
{
    public function setFieldsData(array $fields, SimpleElement $element = null)
    {
        $holidays = (is_array($fields['holiday_ids']['value']))
            ? $fields['holiday_ids']['value']
            : [$fields['holiday_ids']['value']];
        foreach ($holidays as $holiday) {
            $this->getHolidaysGrid()->searchAndSelect(['holiday_name' => $holiday['name']]);
        }
    }
    public function getHolidaysGrid()
    {
        return $this->blockFactory->create(
            'Magento\Storepickup\Test\Block\Adminhtml\Store\Edit\Tab\Holidays\Grid',
            ['element' => $this->_rootElement->find('#storepickupadmin_holiday_grid')]
        );
    }
}