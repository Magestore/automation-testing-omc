<?php
/**
 * Copyright © 2017 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

class GiftcodeMassActionsTest extends Injectable
{
    /**
     * Gift Code Grid Page
     *
     * @var GiftcodeIndex
     */
    protected $giftcodeIndex;

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    public function __inject(
        GiftcodeIndex $giftcodeIndex,
        FixtureFactory $fixtureFactory
    ) {
        $this->giftcodeIndex = $giftcodeIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * Test mass action
     *
     * @param array $giftcode
     * @param array|string $action
     * @param number $count
     * @return array
     */
    public function test(array $giftcode, $action, $count = 1)
    {
        $items = [];
        // Create Gift Codes
        for ($i = 0; $i < $count; $i++) {
            $code = $this->fixtureFactory->createByCode('giftcode', $giftcode);
            $code->persist();
            $items[] = ['giftvoucher_id' => $code->getGiftvoucherId()];
        }

        // Go to gift code grid
        $this->giftcodeIndex->open();

        // Do mass action
        $grid = $this->giftcodeIndex->getGiftcodeGroupGrid();
        $grid->massaction($items, $action, true);

        return ['items' => $items];
    }
}
