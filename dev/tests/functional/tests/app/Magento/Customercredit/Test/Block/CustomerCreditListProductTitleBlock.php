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

/**
 * Class CustomerCreditListProductTitleBlock
 * @package Magento\Customercredit\Test\Block
 */
class CustomerCreditListProductTitleBlock extends Block
{
    /**
     * @var string
     */
    protected $title = '.page-title';

    /**
     * @return array|string
     */
    public function getTitle()
    {
        return $this->_rootElement->find($this->title, Locator::SELECTOR_CSS)->getText();
    }
}