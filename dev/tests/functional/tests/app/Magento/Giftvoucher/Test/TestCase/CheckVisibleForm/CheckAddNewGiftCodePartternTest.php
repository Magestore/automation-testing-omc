<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/11/2017
 * Time: 08:22
 */

namespace Magento\Giftvoucher\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\Giftvoucher\Test\Page\Adminhtml\PatternIndex;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;

/**
 * Class CheckAddNewGiftCodePartternTest
 * @package Magento\Giftvoucher\Test\TestCase
 */
class CheckAddNewGiftCodePartternTest extends Injectable
{
    /**
     * Gift Code Pattern Grid Page
     *
     * @var PatternIndex
     */
    protected $patternIndex;

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
        PatternIndex $patternIndex,
        GiftcodeIndex $giftcodeIndex
    ) {
        $this->patternIndex = $patternIndex;
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
        $this->patternIndex->open();
        $this->giftcodeIndex->getGridPageActions()->addNew();}
}