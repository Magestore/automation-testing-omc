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
	 * Magento form loader.
	 *
	 * @var string
	 */
	protected $spinner = '[data-role="spinner"]';
    /**
     * @var $reason
     */
    protected $firstField = '#reason';

    protected $form = '#edit_form';

    public function getFirstFieldForm()
    {
        return $this->_rootElement->find($this->firstField);
    }

    public function getForm()
    {
        return $this->_rootElement->find($this->form);
    }

	/**
	 * Wait page to load.
	 *
	 * @return void
	 */
	public function waitPageToLoad()
	{
		$this->waitForElementNotVisible($this->spinner);
	}
}
