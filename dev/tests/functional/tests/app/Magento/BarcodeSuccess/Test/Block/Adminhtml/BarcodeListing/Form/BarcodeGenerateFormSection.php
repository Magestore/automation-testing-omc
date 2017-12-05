<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 10:02
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeListing\Form;

use Magento\Ui\Test\Block\Adminhtml\FormSections;

class BarcodeGenerateFormSection extends FormSections
{
    public function getFirstField($firstField)
    {
        return $this->_rootElement->find($firstField);
    }
}
