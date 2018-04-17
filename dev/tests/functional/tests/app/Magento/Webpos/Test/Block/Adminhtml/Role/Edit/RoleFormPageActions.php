<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 01/03/2018
 * Time: 08:14
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Role\Edit;

use Magento\Backend\Test\Block\FormPageActions;
use Magento\Mtf\Client\Locator;


class RoleFormPageActions extends FormPageActions
{
	/**
	 * "Save and Continue Edit" button.
	 *
	 * @var string
	 */
	protected $saveAndContinueButton = '#saveandcontinue';
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