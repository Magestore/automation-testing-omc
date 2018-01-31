<?php
/**
 * Copyright © 2017 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\GiftcardCode;

use Magento\Mtf\TestCase\Injectable;
use Magento\Giftvoucher\Test\Fixture\Giftcode;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeNew;

class UpdateGiftcodeEntityTest extends Injectable
{
    /**
     * Gift code grid page
     *
     * @var GiftcodeIndex
     */
    protected $giftcodeIndex;

    /**
     * Gift code new page
     *
     * @var GiftcodeNew
     */
    protected $giftcodeNew;

    public function __inject(
        GiftcodeIndex $giftcodeIndex,
        GiftcodeNew $giftcodeNew
    ) {
        $this->giftcodeIndex = $giftcodeIndex;
        $this->giftcodeNew = $giftcodeNew;
    }

    public function test(Giftcode $giftcode, Giftcode $update, $action = 'save')
    {
        $giftcode->persist();

        $this->giftcodeIndex->open();
//        $this->giftcodeIndex->getGiftcodeGroupGrid()->searchAndOpen([
//            'gift_code' => $giftcode->getGiftCode()
//        ]);
//
//        $this->giftcodeNew->getGiftcodeForm()->fill($update);
//        $this->giftcodeNew->getGiftcodeMainActions()->$action();

        return ['giftcode' => $giftcode->getData()];
    }
}
