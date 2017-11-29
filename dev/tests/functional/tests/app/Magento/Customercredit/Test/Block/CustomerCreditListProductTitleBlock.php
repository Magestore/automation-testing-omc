<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/28/2017
 * Time: 3:06 PM
 */

namespace Magento\Customercredit\Test\Block;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class CustomerCreditListProductTitleBlock extends Block
{
    protected $title = '.page-title';

    public function getTitle()
    {
        return $this->_rootElement->find($this->title, Locator::SELECTOR_CSS)->getText();
    }
}