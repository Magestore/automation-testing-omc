<?php
/**
 * Copyright © 2017 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\GiftcardCode;

use Magento\Giftvoucher\Test\Fixture\Giftcode as GiftcodeFixture;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeNew;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

class GiftcodeFormButtonsTest extends Injectable
{
    /**
     * Gift Code Grid Page
     *
     * @var GiftcodeIndex
     */
    protected $giftcodeIndex;

    /**
     * Gift Code Form Page
     *
     * @var GiftcodeNew
     */
    protected $giftcodeNew;

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    public function __inject(
        GiftcodeIndex $giftcodeIndex,
        GiftcodeNew $giftcodeNew,
        FixtureFactory $fixtureFactory
    ){
        $this->giftcodeIndex = $giftcodeIndex;
        $this->giftcodeNew = $giftcodeNew;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * Creating Giftcode page.
     *
     * @param array $data
     * @param string $fixtureType
     * @return array
     */
    public function test(array $data, $fixtureType)
    {
        $testResult = [];
        $giftcodeData = $this->fixtureFactory->createByCode($fixtureType, ['data' => $data]);

        /**
         * MGC002
         * ------
         * Steps:
         * 1. Go to Admin > Marketing > Gift Card > Manage Gift Codes
         * 2. Click Add Gift Code button
         *
         * Acceptance Criteria:
         * 1. Display New Gift Code page
         */
        $this->giftcodeIndex->open();
        $this->giftcodeIndex->getGridPageActions()->addNew();
        $testResult['newGiftcodePageShowed'] = $this->giftcodeNew->getGiftcodeForm()->isVisible();
        
        /** 
         * MGC003
         * ------
         * Preconditions:
         * 1. Stay on New Gift Code page
         *
         * Steps:
         * 1. Enter information of Gift Code
         * 2. Click Reset button
         *
         * Acceptance Criteria:
         * 1. Reset the entire page
         */
        $testResult['resetForm'] = [
            'before' => $this->giftcodeNew->getGiftcodeForm()->getData($giftcodeData)
        ];
        $this->giftcodeNew->getGiftcodeForm()->fill($giftcodeData);
        $testResult['resetForm']['filling'] = $this->giftcodeNew->getGiftcodeForm()->getData($giftcodeData);
        $this->giftcodeNew->getGiftcodeMainActions()->reset();
        $testResult['resetForm']['after'] = $this->giftcodeNew->getGiftcodeForm()->getData($giftcodeData);

        /**
         * MGC004
         * ------
         * Preconditions:
         * 1. Stay on New Gift Code page
         *
         * Steps:
         * 1. Click Back button
         *
         * Acceptance Criteria:
         * 1. Go back Gift Code Manager page
         */
        $this->giftcodeNew->getGiftcodeMainActions()->back();
        $testResult['giftcodeGridShowed'] = $this->giftcodeIndex->getGiftcodeGroupGrid()->isVisible();
        
        return ['testResult' => $testResult];
    }
}
