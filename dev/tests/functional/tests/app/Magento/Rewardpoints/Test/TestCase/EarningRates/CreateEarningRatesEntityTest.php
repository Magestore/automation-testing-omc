<?php

/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/6/2017
 * Time: 1:59 PM
 */
namespace Magento\Rewardpoints\Test\TestCase\EarningRates;

use Magento\Mtf\TestCase\Injectable;
use Magento\Rewardpoints\Test\Page\Adminhtml\EarningRatesIndex;
use Magento\Rewardpoints\Test\Page\Adminhtml\EarningRatesNew;
use Magento\Rewardpoints\Test\Fixture\EarningRates;

/**
 *
 * Test Flow:
 * 1. Login as admin
 * 2. Navigate to the Reward points>Earning Rates
 * 3. Click on 'Add New Earning Rate' button
 * 4. Fill out all data according to data set
 * 5. Save
 * 6. Verify created
 *
 */

/**
 * Class CreateEarningRatesEntityTest
 * @package Magento\Rewardpoints\Test\TestCase\EarningRates
 */
class CreateEarningRatesEntityTest extends Injectable
{
    /**
     * @var EarningRatesIndex
     */
    protected $earningRatesIndex;
    /**
     * @var EarningRatesNew
     */
    protected $earningRatesNew;


    /**
     * @param EarningRatesIndex $earningRatesIndex
     * @param EarningRatesNew $earningRatesNew
     */
    public function __inject(EarningRatesIndex $earningRatesIndex, EarningRatesNew $earningRatesNew)
    {
        $this->earningRatesIndex = $earningRatesIndex;
        $this->earningRatesNew = $earningRatesNew;
    }


    /**
     * @param $button
     * @param EarningRates $earningRates
     * @return array
     */
    public function test($button, EarningRates $earningRates)
    {
        $this->earningRatesIndex->open();
        $this->earningRatesIndex->getEarningRatesGridPageActions()->clickActionButton($button);
        $this->earningRatesNew->getEarningRatesForm()->fill($earningRates);
        $this->earningRatesNew->getEarningRatesFormPageActions()->save();
        return ['earning_rates' => $earningRates];
    }
}