<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/11/2017
 * Time: 14:40
 */

namespace Magento\PurchaseOrderSuccess\Test\TestCase;
use Magento\Mtf\TestCase\Injectable;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\ReturnOrderIndex;

class OpenCreateReturnRequestEntityTest extends Injectable
{

	/**
	 * @var ReturnOrderIndex
	 */
	protected $returnOrderIndex;

    public function __inject(
        ReturnOrderIndex $returnOrderIndex
    ) {
        $this->returnOrderIndex = $returnOrderIndex;
    }
    public function test()
    {
        $this->returnOrderIndex->open();
        $this->returnOrderIndex->getPageActionsBlock()->addNew();
        sleep(2);
    }
}