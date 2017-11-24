<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/11/2017
 * Time: 14:40
 */

namespace Magento\PurchaseOrderSuccess\Test\TestCase;
use Magento\Mtf\TestCase\Injectable;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\ReturnRequestIndex;

class OpenCreateReturnRequestEntityTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var ReturnRequestIndex $returnRequestIndex
     */
    protected $returnRequestIndex;

    public function __inject(
        ReturnRequestIndex $returnRequestIndex
    ) {
        $this->returnRequestIndex = $returnRequestIndex;
    }
    public function test()
    {
        $this->returnRequestIndex->open();
        $this->returnRequestIndex->getReturnRequest()->createReturnRequest();
        sleep(2);
    }
}