<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/11/2017
 * Time: 14:18
 */
namespace Magento\PurchaseOrderSuccess\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\QuotationIndex;

class OpenCreateQuotationEntityTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var QuotationIndex $quotationIndex
     */
    protected $quotationIndex;

    public function __inject(
        QuotationIndex $quotationIndex
    ) {
        $this->quotationIndex = $quotationIndex;
    }
    public function test()
    {
        $this->quotationIndex->open();
        $this->quotationIndex->getPageActionsBlock()->addNew();
        sleep(2);
    }
}