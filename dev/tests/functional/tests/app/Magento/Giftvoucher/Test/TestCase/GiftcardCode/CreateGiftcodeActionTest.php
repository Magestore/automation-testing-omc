<?php
/**
 * Copyright © 2017 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeNew;
use Magento\Mtf\TestCase\Injectable;
use Magento\Giftvoucher\Test\Fixture\Giftcode;

class CreateGiftcodeActionTest extends Injectable
{
    /**
     * Gift Code Form Page
     *
     * @var GiftcodeNew
     */
    protected $giftcodeNew;

    public function __inject(
        GiftcodeNew $giftcodeNew
    ){
        $this->giftcodeNew = $giftcodeNew;
    }

    /**
     * Test create gift code with action button
     * 
     * @param Giftcode $giftcode
     * @param array $actions
     */
    public function test(Giftcode $giftcode, array $actions)
    {
        $this->giftcodeNew->open();
        $this->giftcodeNew->getGiftcodeForm()->fill($giftcode);
        
        $actionBlock = $this->giftcodeNew->getGiftcodeMainActions();
        foreach ($actions as $action) {
            $actionBlock->$action();
        }
    }
}
