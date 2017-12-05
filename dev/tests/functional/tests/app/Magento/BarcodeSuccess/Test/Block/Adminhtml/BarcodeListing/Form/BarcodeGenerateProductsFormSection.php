<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 20:29
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeListing\Form;

use Magento\Ui\Test\Block\Adminhtml\FormSections;

class BarcodeGenerateProductsFormSection extends FormSections
{
    /**
     * @method getReasonElement
     */

    public function getFirstField($firstField)
    {
        $firstField = '#'.$firstField;

        return $this->_rootElement->find($firstField)->getText();
    }
}
