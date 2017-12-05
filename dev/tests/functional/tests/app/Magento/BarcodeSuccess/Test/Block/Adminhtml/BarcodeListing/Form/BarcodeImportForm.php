<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 08:57
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeListing\Form;

use Magento\Mtf\Block\Form;

class BarcodeImportForm extends Form
{
    public function getFirstField($firstField)
    {
        return $this->_rootElement->find($firstField);
    }

    public function getForm($form)
    {
        return $this->_rootElement->find($form);
    }

}
