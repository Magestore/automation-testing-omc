<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/11/2017
 * Time: 08:19
 */

namespace Magento\Giftvoucher\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;

/**
 * Class CheckAddGiftCodeTest
 * @package Magento\Giftvoucher\Test\TestCase
 */
class CheckAddGiftCodeTest extends Injectable
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
        $this->giftcodeIndex->getGridPageActions()->addNew();
    }
}