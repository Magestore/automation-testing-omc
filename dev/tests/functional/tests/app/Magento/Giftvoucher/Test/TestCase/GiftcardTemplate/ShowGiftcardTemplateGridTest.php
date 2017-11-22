<?php

namespace Magento\Giftvoucher\Test\TestCase\GiftcardTemplate;

use Magento\Mtf\TestCase\Injectable;
use Magento\Giftvoucher\Test\Fixture\GiftTemplate;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftTemplateIndex;

/**
 * MGCT025
 *
 * 1. Go to Gift Card > Manage Gift Card Templates
 * 2. Display information of list of Gift card Template existing in the system such as: ID, Name, Status, Modified At, Action
 * 3. Display a white page " No records found" if there is no Gift Card Template
 */
class ShowGiftcardTemplateGridTest extends Injectable
{

    private $giftTemplateIndex;

    public function __inject(GiftTemplateIndex $giftTemplateIndex)
    {
        $this->giftTemplateIndex = $giftTemplateIndex;
    }

    public function test(GiftTemplate $giftTemplate)
    {
        $this->giftTemplateIndex->open();
    }

}
