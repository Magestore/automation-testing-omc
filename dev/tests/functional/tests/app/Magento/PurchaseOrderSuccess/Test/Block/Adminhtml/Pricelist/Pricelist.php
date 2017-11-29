<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/11/2017
 * Time: 14:30
 */

namespace Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\Pricelist;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class Pricelist extends Block
{
//    /**
//     * "click add Price List" button
//     *
//     * @var string
//     */
//    protected $buttonAddPriceList = "#container > div > div.entry-edit.form-inline > div > div > fieldset > div.admin__field-complex > div.admin__field-complex-elements > button:nth-child(1)";
//    /**
//     * "click import Price List" button
//     *
//     * @var string
//     */
//    protected $buttonImportPriceList = "#container > div > div.entry-edit.form-inline > div > div > fieldset > div.admin__field-complex > div.admin__field-complex-elements > button:nth-child(2)";

	protected $buttonSelector = '//*[@id="container"]/div/div[2]/div/div/fieldset/div[1]/div[1]/button[span = "%s"]';

    public function createAddPriceList()
    {
//        $this->_rootElement->find($this->buttonAddPriceList)->click();
	    $label = 'Add Pricelist';
        $this->_rootElement->find(sprintf($this->buttonSelector, $label), Locator::SELECTOR_XPATH)->click();
    }

    public function createImportPriceList()
    {
//        $this->_rootElement->find($this->buttonImportPriceList)->click();
	    $label = 'Import Pricelist';
	    $this->_rootElement->find(sprintf($this->buttonSelector, $label), Locator::SELECTOR_XPATH)->click();
    }
}