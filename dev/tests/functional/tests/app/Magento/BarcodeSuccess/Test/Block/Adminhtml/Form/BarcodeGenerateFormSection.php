<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 10:02
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\Form;

use Magento\InventorySuccess\Test\Block\Adminhtml\FormSection;

class BarcodeGenerateFormSection extends FormSection
{
    /**
     * @var $reason
     */
    protected $firstField = '[name="general_information[reason]"]';

    /**
     * @method getReasonElement
     */

    public function getFirstField()
    {
        return $this->_rootElement->find($this->firstField);
    }
}
