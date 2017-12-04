<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 08:21
 */
namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodePrint;

use Magento\Ui\Test\Block\Adminhtml\DataGrid;
/**
 * Adminhtml Print Barcode View management grid.
 */
class PrintBarcodeGrid extends DataGrid
{
    public function tableIsVisible($tableGrid)
    {
        return $this->_rootElement->find($tableGrid)->isVisible();
    }
}
