<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/11/2017
 * Time: 14:40
 */

namespace Magento\PurchaseOrderSuccess\Test\TestCase;
use Magento\Mtf\TestCase\Injectable;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierIndex;

class OpenAddNewSupplierEntityTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var SupplierIndex $supplierIndex
     */
    protected $supplierIndex;

    public function __inject(
        SupplierIndex $supplierIndex
    ) {
        $this->supplierIndex = $supplierIndex;
    }
    public function test()
    {
        $this->supplierIndex->open();
        $this->supplierIndex->getPageActionsBlock()->addNew();
        sleep(2);
    }
}