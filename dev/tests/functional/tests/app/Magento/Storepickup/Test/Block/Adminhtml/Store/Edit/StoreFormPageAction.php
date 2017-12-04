<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 9:32 AM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Store\Edit;

use Magento\Backend\Test\Block\FormPageActions;
use Magento\Mtf\Client\Locator;

/**
 * Class StoreFormPageAction
 * @package Magento\Storepickup\Test\Block\Adminhtml\Store\Edit
 */
class StoreFormPageAction extends FormPageActions
{
    /**
     * @var string
     */
    protected $actionButton = './/button[@id="%s"]';

    /**
     * @return mixed
     */
    public function saveButtonIsVisible()
    {
        return $this->_rootElement->find($this->saveButton, Locator::SELECTOR_CSS)->isVisible();
    }

    /**
     * @param $button
     * @return mixed
     */
    public function actionButtonIsVisible($button)
    {
        return $this->_rootElement->find(sprintf($this->actionButton, $button), Locator::SELECTOR_XPATH)->isVisible();
    }
}