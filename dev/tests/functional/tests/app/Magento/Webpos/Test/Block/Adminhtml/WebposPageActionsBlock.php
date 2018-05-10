<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4/27/18
 * Time: 9:40 AM
 */

namespace Magento\Webpos\Test\Block\Adminhtml;



use Magento\Mtf\Client\Locator;

class WebposPageActionsBlock extends \Magento\Backend\Test\Block\GridPageActions
{
    public function getActionButtonByName($buttonName){
         return $this->_rootElement->find('//div[@class="page-actions-buttons"]//button[*[text()[normalize-space(.)="'.$buttonName.'"]]]',Locator::SELECTOR_XPATH);
    }

    public function getPageTitleByName($title){
        return $this->_rootElement->find('//div[@class="page-actions-inner"][@data-title="'.$title.'"]', Locator::SELECTOR_XPATH);
    }
}