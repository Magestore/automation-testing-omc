<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 13:46
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodePrint\Form;

use Magento\Ui\Test\Block\Adminhtml\FormSections;

class BarcodePrintFormSection extends FormSections
{
    public function getFirstField($firstField)
    {
        $firstField ='[name='.$firstField.']';
        return $this->_rootElement->find($firstField);
    }
}
