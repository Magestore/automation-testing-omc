<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/28/2017
 * Time: 8:45 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\TestCase\ReturnOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\PurchaseOrderSuccess\Test\Fixture\ReturnOrder;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\ReturnOrderIndex;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\ReturnOrderNew;
/**
 *  * Preconditions:
 * 1. Create supplier
 *
 * Test Flow:
 * 1. LoginTest as admin
 * 2. Navigate to the Purchase Management > Return Order
 * 3. Click the "Create Return Request" button.
 * 4. Fill to data
 * 5. Click "Prepare Product List"
 * 5. Verify created
 *
 */
/**
 * Class CreateReturnOrderEntityTest
 * @package Magento\PurchaseOrderSuccess\Test\TestCase\ReturnOrder
 */
class CreateReturnOrderEntityTest extends Injectable
{
    /**
     * @var $returnOrderIndex
     */
    protected $returnOrderIndex;

    /**
     * @var $returnOrderNew
     */
    protected $returnOrderNew;

    /**
     * @param ReturnOrderIndex $returnOrderIndex
     * @param ReturnOrderNew $returnOrderNew
     */
    public function __inject(ReturnOrderIndex $returnOrderIndex, ReturnOrderNew $returnOrderNew)
    {
        $this->returnOrderIndex = $returnOrderIndex;
        $this->returnOrderNew = $returnOrderNew;

    }

    public function test(ReturnOrder $returnOrder)
    {
        $this->returnOrderIndex->open();
        $this->returnOrderIndex->getPageActionsBlock()->addNew();
//        $this->returnOrderNew->getReturnOrderForm()->waitPageToLoad();
        $this->returnOrderNew->getReturnOrderForm()->fill($returnOrder);
        $this->returnOrderNew->getFormPageActions()->save();
    }


}