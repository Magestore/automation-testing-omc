<?php
/**
 * Copyright © 2017 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeNew;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

/**
 * MGC005
 * ------
 * Preconditions:
 * 1. Stay on New Gift Code page
 *
 * Steps:
 * 1. Enter information of Gift Code
 * 2. Click Save and Continue Edit Button
 *
 * Acceptance Criteria:
 * 1. Display saved successful message
 * 2. Stay in Edit Gift Code page
 * 3. Form data equals filled data
 * 
 * 
 * MGC006
 * ------
 * Preconditions:
 * 1. Stay on Edit Gift Code page
 * 
 * Steps:
 * 1. Click Save Button
 * 
 * Acceptance Criteria:
 * 1. Display saved successful message
 * 2. Back to Gift Code Grid Page
 * 
 */
class CreateGiftcodeEntityTest extends Injectable
{
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
        GiftcodeNew $giftcodeNew,
        FixtureFactory $fixtureFactory
    ){
        $this->giftcodeNew = $giftcodeNew;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * Creating Giftcode page.
     *
     * @param array $data
     * @param string $fixtureType
     * @param boolean $saveAndContinue
     * @return array
     */
    public function test(array $data, $fixtureType, $saveAndContinue = false)
    {
        $giftcode = null;
        $giftcodeData = $this->fixtureFactory->createByCode($fixtureType, ['data' => $data]);

        $this->giftcodeNew->open();
        $this->giftcodeNew->getGiftcodeForm()->fill($giftcodeData);
        
        // MGC005
        if ($saveAndContinue) {
            $this->giftcodeNew->getGiftcodeMainActions()->saveAndContinue();
            $giftcode = $this->giftcodeNew->getGiftcodeForm()->getData($giftcodeData);
        }
        
        // MGC006
        $this->giftcodeNew->getGiftcodeMainActions()->save();
        
        return ['giftcode' => $giftcode];
    }
}
