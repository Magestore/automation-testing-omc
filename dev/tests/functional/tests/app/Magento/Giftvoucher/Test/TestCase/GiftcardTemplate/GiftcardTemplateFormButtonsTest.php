<?php
/**
 * Copyright © 2017 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\GiftcardTemplate;

use Magento\Giftvoucher\Test\Fixture\GiftTemplate as GiftTemplateFixture;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftTemplateIndex;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftTemplateNew;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

class GiftcardTemplateFormButtonsTest extends Injectable
{
    /**
     * Gift Code Grid Page
     *
     * @var GiftTemplateIndex
     */
    protected $giftTemplateIndex;

    /**
     * Gift Code Form Page
     *
     * @var GiftTemplateNew
     */
    protected $giftTemplateNew;

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    public function __inject(
        GiftTemplateIndex $giftTemplateIndex,
        GiftTemplateNew $giftTemplateNew,
        FixtureFactory $fixtureFactory
    ){
        $this->giftTemplateIndex = $giftTemplateIndex;
        $this->giftTemplateNew = $giftTemplateNew;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * Creating Gift Template page.
     *
     * @param array $data
     * @param string $fixtureType
     * @return array
     */
    public function test(array $data, $fixtureType)
    {
        $testResult = [];
        $giftTemplateData = $this->fixtureFactory->createByCode($fixtureType, ['data' => $data]);

        /**
         * MGCT002
         * ------
         * Steps:
         * 1. Go to Admin > Marketing > Gift Card > Manage Gift Card Template
         * 2. Click Add New Template button
         *
         * Acceptance Criteria:
         * 1. Display New Gift Card Template page
         */
        $this->giftTemplateIndex->open();
        $this->giftTemplateIndex->getGridPageActions()->addNew();
        $testResult['newGiftTemplatePageShowed'] = $this->giftTemplateNew->getForm()->isVisible();
        
        /** 
         * MGCT004
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
            'before' => $this->giftTemplateNew->getForm()->getData($giftTemplateData)
        ];
        $this->giftTemplateNew->getForm()->fill($giftTemplateData);
        $testResult['resetForm']['filling'] = $this->giftTemplateNew->getForm()->getData($giftTemplateData);
        $this->giftTemplateNew->getGiftTemplateMainActions()->reset();
        $testResult['resetForm']['after'] = $this->giftTemplateNew->getForm()->getData($giftTemplateData);

        /**
         * MGCT003
         * ------
         * Preconditions:
         * 1. Stay on New Gift Card Template page
         *
         * Steps:
         * 1. Click Back button
         *
         * Acceptance Criteria:
         * 1. Go back Gift Card Template Manager page
         */
        $this->giftTemplateNew->getGiftTemplateMainActions()->back();
        $testResult['giftTemplateGridShowed'] = $this->giftTemplateIndex->getGiftTemplateGroupGrid()->isVisible();
        
        return ['testResult' => $testResult];
    }
}
