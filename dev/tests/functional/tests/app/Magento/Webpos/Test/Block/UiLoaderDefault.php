<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 10/06/2018
 * Time: 14:20
 */

namespace Magento\Webpos\Test\Block;


use Magento\Mtf\Block\Block;

/**
 * Class UiLoaderDefault
 * @package Magento\Webpos\Test\Block
 */
class UiLoaderDefault extends Block
{
    public function waitForLoadingDefaultHidden()
    {
        $uiIconLoading = $this->_rootElement->find('.ui-icon-loading');
        if($uiIconLoading->isVisible())
        {
            \Zend_Debug::dump('UiLoaderDefault visible');
            $this->waitForElementNotVisible('.ui-icon-loading');
        }
    }
}