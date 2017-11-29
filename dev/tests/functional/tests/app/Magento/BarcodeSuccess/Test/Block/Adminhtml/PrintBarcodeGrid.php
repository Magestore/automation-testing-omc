<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 08:21
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml;

use Magento\Ui\Test\Block\Adminhtml\DataGrid;
/**
 * Adminhtml Print Barcode View management grid.
 */
class PrintBarcodeGrid extends DataGrid
{
    public function TableIsVisible()
    {
        return $this->_rootElement->find('#container > div > div.entry-edit.form-inline > div.admin__scope-old.os_barcode_print_form_os_barcode_print_form_barcode_print_listing > div > div.admin__data-grid-wrap > table')->isVisible();
    }
}
