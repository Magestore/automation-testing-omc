<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 20:53
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\Form;

use Magento\InventorySuccess\Test\Block\Adminhtml\FormSection;

class BarcodeViewTemplateFormSection extends FormSection
{
    /**
     * @var $reason
     */
    protected $firstField = '[name="type"]';

    /**
     * @method getReasonElement
     */

    public function getFirstField()
    {
        return $this->_rootElement->find($this->firstField);
    }
}
