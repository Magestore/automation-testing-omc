<?php
/**
 * Copyright © 2017 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\GiftcardTemplate;

use Magento\Giftvoucher\Test\Fixture\GiftTemplate as GiftTemplateFixture;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftTemplateIndex;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftTemplateNew;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftTemplateEdit;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

/**
 * MGCT022
 * ------
 * Preconditions:
 * 1. Stay on New Giftcard Tempalte page
 *
 * Steps:
 * 1. Enter information of Giftcard Template
 * 2. Click Save and Continue Edit Button
 *
 * Acceptance Criteria:
 * 1. Display saved successful message
 * 2. Stay in Edit Giftcard Template page
 * 3. Form data equals filled data
 * 
 * 
 * MGCT023
 * ------
 * Preconditions:
 * 1. Stay on Edit Giftcard Tempalte page
 * 
 * Steps:
 * 1. Click Save Button
 * 
 * Acceptance Criteria:
 * 1. Display saved successful message
 * 2. Back to Giftcard Template Grid Page
 * 
 */
class CreateGiftcardTemplateEntityTest extends Injectable
{
    /**
     * Gift Template Grid Page
     *
     * @var GiftTemplateIndex
     */
    protected $giftTemplateIndex;

    /**
     * Gift Template Form Page
     *
     * @var GiftTemplateNew
     */
    protected $giftTemplateNew;
    
    /**
     * Gift Template Form Page
     *
     * @var GiftTemplateEdit
     */
    protected $giftTemplateEdit;

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    public function __inject(
        GiftTemplateIndex $giftTemplateIndex,
        GiftTemplateNew $giftTemplateNew,
        GiftTemplateEdit $giftTemplateEdit,
        FixtureFactory $fixtureFactory
    ){
        $this->giftTemplateIndex = $giftTemplateIndex;
        $this->giftTemplateNew = $giftTemplateNew;
        $this->giftTemplateEdit = $giftTemplateEdit;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * Creating GiftTemplate page.
     *
     * @param array $data
     * @param string $fixtureType
     * @param boolean $saveAndContinue
     * @return array
     */
    public function test(array $data, $fixtureType, $saveAndContinue = false)
    {
        $giftTemplate = null;
        $giftTemplateData = $this->fixtureFactory->createByCode($fixtureType, ['data' => $data]);

        $this->giftTemplateNew->open();
        $this->giftTemplateNew->getForm()->fill($giftTemplateData);
        
        // MGCT022
        if ($saveAndContinue) {
            $this->giftTemplateNew->getGiftTemplateMainActions()->saveAndContinue();
            $giftTemplate = $this->giftTemplateNew->getForm()->getData($giftTemplateData);
        }
        
        // MGCT023
        $this->giftTemplateNew->getGiftTemplateMainActions()->save();
        
        return ['giftTemplate' => $giftTemplate];
    }
}
