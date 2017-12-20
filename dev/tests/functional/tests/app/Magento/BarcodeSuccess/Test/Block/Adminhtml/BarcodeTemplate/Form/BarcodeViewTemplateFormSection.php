<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 20:53
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeTemplate\Form;

use Magento\Ui\Test\Block\Adminhtml\FormSections;

class BarcodeViewTemplateFormSection extends FormSections
{
    /**
     * @method getReasonElement
     */

    public function getField($field)
    {
        $field ='[name='.$field.']';
        return $this->_rootElement->find($field);
    }

    public function getMessageRequired($wrap, $class)
    {
        $class = '[class=' . $class . ']';
        return $this->getElementWarpField($wrap)->find($class);
    }

    public function getElementWarpField($wrap)
    {
        $wrap ='[data-index='.$wrap.']';
        return $this->_rootElement->find($wrap);
    }
}
