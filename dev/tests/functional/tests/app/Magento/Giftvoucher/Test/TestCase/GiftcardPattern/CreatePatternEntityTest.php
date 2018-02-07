<?php
/**
 * Copyright © 2017 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\GiftcardPattern;

use Magento\Giftvoucher\Test\Page\Adminhtml\PatternIndex;
use Magento\Giftvoucher\Test\Page\Adminhtml\PatternNew;
use Magento\Giftvoucher\Test\Page\Adminhtml\PatternEdit;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

/**
 * GGC006
 * ------
 * Preconditions:
 * 1. Stay on New Gift Code Pattern page
 *
 * Steps:
 * 1. Enter information of Gift Code Pattern
 * 2. Click Save and Continue Edit Button
 *
 * Acceptance Criteria:
 * 1. Display saved successful message
 * 2. Stay in Edit Gift Code Pattern page
 * 3. Form data equals filled data
 * 
 * 
 * GGC005
 * ------
 * Preconditions:
 * 1. Stay on Edit Gift Code Pattern page
 * 
 * Steps:
 * 1. Click Save Button
 * 
 * Acceptance Criteria:
 * 1. Display saved successful message
 * 2. Back to Gift Code Pattern Grid Page
 * 
 */
class CreatePatternEntityTest extends Injectable
{
    /**
     * Gift Code Pattern Grid Page
     *
     * @var PatternIndex
     */
    protected $patternIndex;

    /**
     * Gift Code Pattern Form Page
     *
     * @var PatternNew
     */
    protected $patternNew;
    
    /**
     * Gift Code Pattern Form Page
     *
     * @var PatternEdit
     */
    protected $patternEdit;

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    public function __inject(
        PatternIndex $patternIndex,
        PatternNew $patternNew,
        PatternEdit $patternEdit,
        FixtureFactory $fixtureFactory
    ){
        $this->patternIndex = $patternIndex;
        $this->patternNew = $patternNew;
        $this->patternEdit = $patternEdit;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * Creating gift code pattern page.
     *
     * @param array $data
     * @param string $fixtureType
     * @param boolean $saveAndContinue
     * @return array
     */
    public function test(array $data, $fixtureType, $saveAndContinue = false)
    {
        $pattern = null;
        $patternData = $this->fixtureFactory->createByCode($fixtureType, ['data' => $data]);

        $this->patternNew->open();
        $this->patternNew->getPatternForm()->fill($patternData);
        
        // GGC006
        if ($saveAndContinue) {
            $this->patternNew->getPatternMainActions()->saveAndContinue();
            $pattern = $this->patternNew->getPatternForm()->getData($patternData);
        }
        
        // GGC005
        $this->patternNew->getPatternMainActions()->save();
        
        return ['pattern' => $pattern];
    }
}
