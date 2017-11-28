<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 27/11/2017
 * Time: 08:57
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\Form;
use Magento\Mtf\Block\Form;
class BarcodeImportForm extends Form
{
    /**
     * @var $reason
     */
    protected $firstField = '#reason';
    protected $form = '#edit_form';
    /**
     * @method getReasonElement
     */

    public function getFirstFieldForm()
    {
        return $this->_rootElement->find($this->firstField);
    }
    public function getForm()
    {
        return $this->_rootElement->find($this->form);
    }
}
