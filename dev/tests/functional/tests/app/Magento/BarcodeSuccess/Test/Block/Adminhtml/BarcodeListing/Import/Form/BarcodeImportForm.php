<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 08:57
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeListing\Import\Form;

use Magento\Mtf\Block\Form;

class BarcodeImportForm extends Form
{
    public function getFirstField($firstField)
    {
        return $this->_rootElement->find($firstField);
    }
    public function getField($field)
    {
        return $this->_rootElement->find($field);
    }
    public function getForm($form)
    {
        return $this->_rootElement->find($form);
    }

    public function fillNotFixture(array $formFields){
        $mapping = $this->dataMapping($formFields);
        $this->_fill($mapping);
        return $this;
    }

}
