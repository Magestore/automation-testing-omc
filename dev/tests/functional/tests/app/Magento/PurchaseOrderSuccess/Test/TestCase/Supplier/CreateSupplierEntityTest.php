<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/25/2017
 * Time: 1:44 PM
 */

namespace Magento\PurchaseOrderSuccess\Test\TestCase\Supplier;

use Magento\Mtf\TestCase\Injectable;
use Magento\PurchaseOrderSuccess\Test\Fixture\Supplier;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierIndex;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierNew;

/**
 * Steps:
 * 1. LoginTest to the backend.
 * 2. Navigate to Purchase Management > Manage Suppliers.
 * 3. Start to Add New Supplier.
 * 4. Fill in data according to data set.
 * 5. Save Supplier.
 * 6. Perform appropriate assertions.
 *
 */
class CreateSupplierEntityTest extends Injectable
{
    /**
     * @var SupplierIndex
     */
    protected $supplierIndex;

    /**
     * @var SupplierNew
     */
    protected $supplierNew;

    /**
     * @param SupplierIndex $supplierIndex
     * @param SupplierNew $supplierNew
     */
    public function __inject(SupplierIndex $supplierIndex, SupplierNew $supplierNew)
    {
     $this->supplierIndex = $supplierIndex;
     $this->supplierNew = $supplierNew;
    }

    public function test(Supplier $supplier)
    {
        $this->supplierIndex->open();
        $this->supplierIndex->getPageActionsBlock()->addNew();
        $this->supplierNew->getSupplierForm()->waitPageToLoad();
        $this->supplierNew->getSupplierForm()->fill($supplier);
        $this->supplierNew->getFormPageActions()->save();
    }
}