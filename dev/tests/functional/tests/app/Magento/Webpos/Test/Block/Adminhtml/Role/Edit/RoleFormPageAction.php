<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/28/2018
 * Time: 4:18 PM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Role\Edit;

use Magento\Backend\Test\Block\FormPageActions;
use Magento\Mtf\Client\Locator;

/**
 * Class RoleFormPageAction
 * @package Magento\Webpos\Test\Block\Adminhtml\Role\Edit
 */
class RoleFormPageAction extends FormPageActions
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
    public function actionButton($button)
    {
        return $this->_rootElement->find(sprintf($this->actionButton, $button), Locator::SELECTOR_XPATH);
    }
}