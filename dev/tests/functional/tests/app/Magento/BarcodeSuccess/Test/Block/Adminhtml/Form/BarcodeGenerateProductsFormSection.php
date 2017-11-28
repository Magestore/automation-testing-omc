<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 20:29
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\Form;
use Magento\Ui\Test\Block\Adminhtml\FormSections;
class BarcodeGenerateProductsFormSection extends FormSections
{
    /**
     * @var $reason
     */
    protected $firstField = '#container > div > div.entry-edit.form-inline > div:nth-child(2) > div.fieldset-wrapper-title > strong';

    /**
     * @method getReasonElement
     */

    public function getFirstField()
    {
        return $this->_rootElement->find($this->firstField)->getText();
    }
}
