<?php
/**
 * Copyright © 2017 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\GiftcardCode;

use Magento\Giftvoucher\Test\Fixture\Giftcode as GiftcodeFixture;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeEdit;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

/**
 * MGC010
 * ------
 * Preconditions:
 * 1. Stay on Gift Code Grid page
 *
 * Steps:
 * 1. Select Gift Code
 * 2. Click Delete on Massaction
 *
 * Acceptance Criteria:
 * 1. Display message notifying Delete Gift Code successfully
 * 2. Gift Code Grid does not contain this Gift Code
 * 
 * 
 * MGC011
 * ------
 * Preconditions:
 * 1. Stay on Gift Code Grid page
 * 
 * Steps:
 * 1. Open Gift Code Edit page
 * 2. Click Delete button
 * 
 * Acceptance Criteria:
 * 1. Display message notifying Delete Gift Code successfully
 * 2. Gift Code Grid does not contain this Gift Code
 * 
 */
class DeleteGiftcodeEntityTest extends Injectable
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
     * @var GiftcodeEdit
     */
    protected $giftcodeEdit;
    
    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    public function __inject(
        GiftcodeIndex $giftcodeIndex,
        GiftcodeEdit $giftcodeEdit,
        FixtureFactory $fixtureFactory
    ){
        $this->giftcodeIndex = $giftcodeIndex;
        $this->giftcodeEdit = $giftcodeEdit;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * Delete Giftcode page.
     *
     * @param string $fixtureType
     * @param string $dataset
     * @return array
     */
    public function test($fixtureType, $dataset)
    {
        $messages = [];
        $giftcodes = $this->createGiftcodes($fixtureType, $dataset, 2);
        $grid = $this->giftcodeIndex->getGiftcodeGroupGrid();
        
        // MGC010
        $this->giftcodeIndex->open();
        $grid->massaction([
            ['giftvoucher_id' => $giftcodes[0]->getGiftvoucherId()],
        ], 'Delete', true);
        $messages['mass_delete'] = $this->giftcodeIndex->getMessagesBlock()->getSuccessMessage();
        
        // MGC011
        $grid->searchAndOpen(['gift_code' => $giftcodes[1]->getGiftCode()]);
        $this->giftcodeEdit->getGiftcodeMainActions()->delete();
        $this->giftcodeEdit->getModalBlock()->acceptAlert();
        $messages['delete'] = $this->giftcodeIndex->getMessagesBlock()->getSuccessMessage();
        
        return ['giftcodes' => $giftcodes, 'messages' => $messages];
    }
    
    protected function createGiftcodes($fixtureType, $dataset, $number) {
        $giftcodes = [];
        for ($i = 0; $i < $number; $i++) {
            $giftcode = $this->fixtureFactory->createByCode($fixtureType, ['dataset' => $dataset]);
            $giftcode->persist();
            $giftcodes[] = $giftcode;
        }
        return $giftcodes;
    }
}
