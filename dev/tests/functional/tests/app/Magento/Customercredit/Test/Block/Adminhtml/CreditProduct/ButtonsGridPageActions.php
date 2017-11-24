<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/22/2017
 * Time: 4:14 PM
 */

namespace Magento\Customercredit\Test\Block\Adminhtml\CreditProduct;

use Magento\Backend\Test\Block\GridPageActions;
use Magento\Mtf\Client\Locator;

class ButtonsGridPageActions extends GridPageActions
{
    protected $actionButton = './/button[span="%s"]';


    public function actionButtonIsVisible($button)
    {
        return $this->_rootElement->find(sprintf($this->actionButton, $button), Locator::SELECTOR_XPATH)->isVisible();
    }

    public function clickActionButton($actionButton)
    {
        $button = $this->_rootElement->find(sprintf($this->actionButton, $actionButton), Locator::SELECTOR_XPATH);
        if (!$button->isVisible()) {
            throw new \Exception('Main menu item "' . $actionButton . '" is not visible.');
        }
        $button->click();
        $this->waitForElementNotVisible(sprintf($this->actionButton, $actionButton), Locator::SELECTOR_XPATH);
    }
}