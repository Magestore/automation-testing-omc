<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/8/2017
 * Time: 9:54 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Store\Edit\Tab;

use Magento\Backend\Test\Block\Widget\Tab;
use Magento\Mtf\Client\Element\SimpleElement;

class Tags extends Tab
{
    public function setFieldsData(array $fields, SimpleElement $element = null)
    {
        $tags = (is_array($fields['tag_ids']['value']))
            ? $fields['tag_ids']['value']
            : [$fields['tag_ids']['value']];
        foreach ($tags as $tag) {
            $this->getTagsGrid()->searchAndSelect(['tag_name' => $tag['name']]);
        }
    }

    public function getTagsGrid()
    {
        return $this->blockFactory->create(
            'Magento\Storepickup\Test\Block\Adminhtml\Store\Edit\Tab\Tags\Grid',
            ['element' => $this->_rootElement->find('#storepickupadmin_tag_grid')]
        );
    }
}