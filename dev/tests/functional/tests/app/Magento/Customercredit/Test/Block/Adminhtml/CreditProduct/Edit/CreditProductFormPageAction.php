<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/26/2017
 * Time: 9:50 PM
 */

namespace Magento\Customercredit\Test\Block\Adminhtml\CreditProduct\Edit;

use Magento\Catalog\Test\Block\Adminhtml\Product\FormPageActions;
use Magento\Mtf\Client\Locator;

class CreditProductFormPageAction extends FormPageActions
{
    protected $actionButton = './/button[span="%s"]';

    public function actionButtonIsVisible($button)
    {
        return $this->_rootElement->find(sprintf($this->actionButton, $button), Locator::SELECTOR_XPATH)->isVisible();
    }
}