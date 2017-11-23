<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/11/2017
 * Time: 18:03
 */

namespace Magento\Giftvoucher\Test\TestCase\CheckVisibleForm;

use Magento\Mtf\TestCase\Injectable;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftvoucherProductIndex;

class CheckAddGiftCardProductTest extends Injectable
{

    /**
     * Product page with a grid
     *
     * @var GiftvoucherProductIndex
     */
    protected $productGrid;

    /**
     * Injection data
     *
     * @param GiftvoucherProductIndex $productGrid
     * @return void
     */
    public function __inject(GiftvoucherProductIndex $productGrid)
    {
        $this->productGrid = $productGrid;
    }

    /**
     * Run check visible form Check Add Gift Code entity test
     *
     * @return void
     */
    public function testCreate()
    {
        // Steps
        $this->productGrid->open();
        $this->productGrid->getGridPageActionBlock()->getAddGiftCardProduct()->click();
    }
}