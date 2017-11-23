<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/11/2017
 * Time: 13:55
 */

namespace Magento\FulfilReport\Test\Block\Adminhtml;

use Magento\Mtf\Block\Block;
/**
 * Class PageWrapper
 * @package Magento\FulfilReport\Test\Block\Adminhtml
 */
class PageWrapper extends Block
{
    public function getAnchorContent()
    {
        return '#anchor-content';
    }

    public function getMainContainer()
    {
        return '#anchor-content > div.page-columns';
    }
}