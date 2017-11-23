<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/11/2017
 * Time: 14:04
 */
namespace Magento\PurchaseOrderSuccess\Test\TestCase;
use Magento\Mtf\TestCase\Injectable;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\PurchaseOrderIndex;

class OpenCreatePurchaseOrderEntityTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var PurchaseOrderIndex $purchaseOrderIndex
     */
    protected $purchaseOrderIndex;

    public function __inject(
        PurchaseOrderIndex $purchaseOrderIndex
    ) {
        $this->purchaseOrderIndex = $purchaseOrderIndex;
    }
    public function test()
    {
        $this->purchaseOrderIndex->open();
        $this->purchaseOrderIndex->getPurchaseOrder()->createPurchaseOrder();
        sleep(2);
    }
}