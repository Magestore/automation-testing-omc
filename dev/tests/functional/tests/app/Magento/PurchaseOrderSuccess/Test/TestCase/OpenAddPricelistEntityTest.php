<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/11/2017
 * Time: 14:54
 */

namespace Magento\PurchaseOrderSuccess\Test\TestCase;
use Magento\Mtf\TestCase\Injectable;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\PricelistIndex;

class OpenAddPricelistEntityTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var PricelistIndex $pricelistIndex
     */
    protected $pricelistIndex;

    public function __inject(
        PricelistIndex $pricelistIndex
    ) {
        $this->pricelistIndex = $pricelistIndex;
    }
    public function test()
    {
        $this->pricelistIndex->open();
        sleep(2);
        $this->pricelistIndex->getPricelist()->createAddPriceList();
        sleep(2);
    }
}