<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 10:02
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeListing\Generate\Form;
use Magento\Mtf\Client\Element\SimpleElement;
use Magento\Ui\Test\Block\Adminhtml\FormSections;
use Magento\Mtf\Client\Locator;

class BarcodeGenerateFormSection extends FormSections
{
    protected $gridTable = '.data-grid';

    protected $loadingMask = '.admin__data-grid-loading-mask';

    public function getFirstField($firstField)
    {
        return $this->_rootElement->find($firstField);
    }

    public function setField($firstField)
    {
        return $this->_rootElement->find($firstField);
    }
    public function setFieldsData(array $fields, SimpleElement $contextElement = null)
    {
        $this->waitingForGridVisible();
        $data = $this->dataMapping($fields);
        $this->waitingForGridVisible();
        $this->_fill($data, $contextElement);

        return $this;
    }
    public function waitingForGridVisible()
    {
//        $this->waitLoader();
        $this->waitForElementNotVisible($this->loadingMask, Locator::SELECTOR_CSS);
        $this->waitForElementVisible($this->gridTable, Locator::SELECTOR_CSS);
    }
    public function clickSelectProducts()
    {
        $this->_rootElement->find('[data-index="grouped_products_button"]')->click();

    }
}
