<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/25/18
 * Time: 4:30 PM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Report\Viewed;


use Magento\Mtf\Client\Locator;
use Magento\Mtf\Block\Block;

class ReportBlock extends Block
{
    public function getTableFieldByTitle($title)
    {
        return $this->_rootElement->find('.//table/thead/tr//th/span[text()="' . $title . '"]', locator::SELECTOR_XPATH);
    }
}