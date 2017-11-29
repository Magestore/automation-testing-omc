<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/11/2017
 * Time: 17:03
 */

namespace Magento\Giftvoucher\Test\TestCase\CheckVisibleForm;

use Magento\Mtf\TestCase\Injectable;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftvoucherProductIndex;

/**
 * Class CheckAddGiftCardProductTest
 * @package Magento\Giftvoucher\Test\TestCase
 */
class CheckAddGiftCardProductTest extends Injectable
{
    /**
     * Product page with a grid
     *
     * @var GiftvoucherProductIndex
     */
    protected $productGrid;

    /**
     * Run menu navigation test.
     *
     * Injection data
     *
     * @param GiftvoucherProductIndex $productGrid
     * @return void
     */
    public function __inject
    (
        GiftvoucherProductIndex $productGrid
    )
    {
        $this->productGrid = $productGrid;
    }

    /**
     * Run create product virtual entity test
     *
     * @return void
     */
    public function test()
    {
        $this->productGrid->open();
        $this->productGrid->getGridPageActionBlock()->getAddGiftCardProduct()->click();}
}