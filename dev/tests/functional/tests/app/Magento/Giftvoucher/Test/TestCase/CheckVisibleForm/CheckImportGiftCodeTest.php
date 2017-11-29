<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/11/2017
 * Time: 17:33
 */

namespace Magento\Giftvoucher\Test\TestCase\CheckVisibleForm;

use Magento\Mtf\TestCase\Injectable;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;

/**
 * Class CheckImportGiftCodeTest
 * @package Magento\Giftvoucher\Test\TestCase
 */
class CheckImportGiftCodeTest extends Injectable
{
    /**
     * Gift Code Grid Page
     *
     * @var GiftcodeIndex
     */
    protected $giftcodeIndex;

    /**
     * Injection data
     *
     * @param GiftcodeIndex $giftcodeIndex
     * @return void
     */
    public function __inject(
        GiftcodeIndex $giftcodeIndex
    ) {
        $this->giftcodeIndex = $giftcodeIndex;
    }

    /**
     * Run check visible form Check Add Gift Code entity test
     *
     * @return void
     */
    public function testCreate()
    {
        // Steps
        $this->giftcodeIndex->open();
        $this->giftcodeIndex->getGridPageActions()->import();}
}