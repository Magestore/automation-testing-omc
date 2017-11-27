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

class StoreImportStoreForm extends Form
{
    protected $importStoreTitle = './/span[text()="Import Information"]';

    protected $importFileField = '[data-ui-id="storepickup-store-import-form-fieldset-element-form-field-filecsv"]';

    public function importStoreTitleIsVisible()
    {
        return $this->_rootElement->find($this->importStoreTitle, Locator::SELECTOR_XPATH)->isVisible();
    }

    public function importFileFieldIsVisible()
    {
        return $this->_rootElement->find($this->importFileField, Locator::SELECTOR_CSS)->isVisible();
    }
}