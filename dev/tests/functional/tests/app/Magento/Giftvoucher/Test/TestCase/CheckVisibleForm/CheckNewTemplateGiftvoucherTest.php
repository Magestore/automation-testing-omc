<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/11/2017
 * Time: 08:27
 */

namespace Magento\Giftvoucher\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftTemplateIndex;

/**
 * Class CheckNewTemplateGiftvoucherTest
 * @package Magento\Giftvoucher\Test\TestCase
 */
class CheckNewTemplateGiftvoucherTest extends Injectable
{
    /**
     * Gift Template Grid Page
     *
     * @var GiftTemplateIndex
     */
    protected $giftTemplateIndex;

    /**
     * Injection data
     *
     * @param GiftTemplateIndex $giftTemplateIndex
     * @return void
     */
    public function __inject(
        GiftTemplateIndex $giftTemplateIndex
    ) {
        $this->giftTemplateIndex = $giftTemplateIndex;
    }

    /**
     * Run check visible form Check Add Gift Code entity test
     *
     * @return void
     */
    public function testCreate()
    {
        // Steps
        $this->giftTemplateIndex->open();
        $this->giftTemplateIndex->getGridPageActions()->addNew();}
}