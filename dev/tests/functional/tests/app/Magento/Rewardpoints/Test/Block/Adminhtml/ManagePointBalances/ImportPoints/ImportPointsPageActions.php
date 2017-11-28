<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 12:21 PM
 */

namespace Magento\Rewardpoints\Test\Block\Adminhtml\Store\ImportStore;


use Magento\Backend\Test\Block\FormPageActions;
use Magento\Mtf\Client\Locator;

class ImportPointsPageActions extends FormPageActions
{
    protected $actionButton = './/button[@title="%s"]';

    public function actionButtonIsVisible($button)
    {
        return $this->_rootElement->find(sprintf($this->actionButton, $button), Locator::SELECTOR_XPATH)->isVisible();
    }
}
