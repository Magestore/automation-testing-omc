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

    public function getFirstField($firstField)
    {
        $firstField ='[name='.$firstField.']';
        return $this->_rootElement->find($firstField);
    }
}
