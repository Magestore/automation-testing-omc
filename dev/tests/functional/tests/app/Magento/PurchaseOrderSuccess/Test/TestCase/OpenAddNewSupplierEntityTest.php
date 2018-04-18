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
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierNew;

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

    /**
     * @var SupplierNew
     */
    protected $supplierNew;

    public function __inject(
        SupplierIndex $supplierIndex,
        SupplierNew $supplierNew
    ) {
        $this->supplierIndex = $supplierIndex;
        $this->supplierNew = $supplierNew;
    }

    public function test()
    {
        $this->supplierIndex->open();
        $this->supplierIndex->getPageActionsBlock()->addNew();
        $this->supplierNew->getSupplierForm()->waitPageToLoad();
    }
}