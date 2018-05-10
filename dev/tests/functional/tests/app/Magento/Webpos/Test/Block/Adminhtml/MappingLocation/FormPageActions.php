<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 17/02/2018
 * Time: 19:58
 */
namespace Magento\Webpos\Test\Block\Adminhtml\MappingLocation;
use Magento\Mtf\Client\Locator;
use Magento\Backend\Test\Block\PageActions;
/**
 * Class FormPageActions
 * Form page actions block
 *
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
class FormPageActions extends PageActions
{
    /**
     * "Back" button.
     *
     * @var string
     */
    protected $cancelButton = '#cancel';

    /**
     * "Save" button.
     *
     * @var string
     */
    protected $saveButton = '#save';

    /**
     * Magento new loader.
     *
     * @var string
     */
    protected $spinner = '[data-role="spinner"]';

    /**
     * Magento loader.
     *
     * @var string
     */
    protected $loader = '//ancestor::body/div[@data-role="loader"]';

    /**
     * Magento varienLoader.js loader.
     *
     * @var string
     */
    protected $loaderOld = '//ancestor::body/div[@id="loading-mask"]';

    /**
     * Click "Back" button.
     */
    public function cancel()
    {
        $this->_rootElement->find($this->cancelButton)->click();
    }


    /**
     * Click "Save" button.
     */
    public function save()
    {
        $this->waitForElementVisible($this->saveButton);
        $this->_rootElement->find($this->saveButton)->click();
        $this->waitForElementNotVisible($this->spinner);
        $this->waitForElementNotVisible($this->loader, Locator::SELECTOR_XPATH);
        $this->waitForElementNotVisible($this->loaderOld, Locator::SELECTOR_XPATH);
    }

    public function getButtonById($id)
    {
        $this->waitForElementNotVisible($this->spinner);
        $this->waitForElementNotVisible($this->loader, Locator::SELECTOR_XPATH);
        $this->waitForElementNotVisible($this->loaderOld, Locator::SELECTOR_XPATH);
        return $this->_rootElement->find('#'.$id);
    }

    public function getButtonByName($name){
        return $this->_rootElement->find('//button/span[text()="'.$name.'"]', locator::SELECTOR_XPATH);
    }
}
