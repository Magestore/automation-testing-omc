<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 1:10 PM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Store\ImportStore;

use Magento\Mtf\Block\Form;
use Magento\Mtf\Client\Locator;

/**
 * Class StoreImportStoreForm
 * @package Magento\Storepickup\Test\Block\Adminhtml\Store\ImportStore
 */
class StoreImportStoreForm extends Form
{
    /**
     * @var string
     */
    protected $importStoreTitle = './/span[text()="Import Information"]';

    /**
     * @var string
     */
    protected $importFileField = '[data-ui-id="storepickup-store-import-form-fieldset-element-form-field-filecsv"]';

    /**
     * @return mixed
     */
    public function importStoreTitleIsVisible()
    {
        return $this->_rootElement->find($this->importStoreTitle, Locator::SELECTOR_XPATH)->isVisible();
    }

    /**
     * @return mixed
     */
    public function importFileFieldIsVisible()
    {
        return $this->_rootElement->find($this->importFileField, Locator::SELECTOR_CSS)->isVisible();
    }
}