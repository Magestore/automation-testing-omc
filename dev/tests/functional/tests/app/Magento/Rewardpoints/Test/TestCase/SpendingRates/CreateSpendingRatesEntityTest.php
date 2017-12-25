<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/8/2017
 * Time: 9:46 AM
 */

namespace Magento\Rewardpoints\Test\TestCase\SpendingRates;

use Magento\Mtf\TestCase\Injectable;
use Magento\Rewardpoints\Test\Page\Adminhtml\SpendingRatesIndex;
use Magento\Rewardpoints\Test\Page\Adminhtml\SpendingRatesNew;
use Magento\Rewardpoints\Test\Fixture\SpendingRates;

/**
 *
 * Test Flow:
 * 1. Login as admin
 * 2. Navigate to the Reward points>Spending Rates
 * 3. Click on 'Add New Spending Rate' button
 * 4. Fill out all data according to data set
 * 5. Save
 * 6. Verify created
 *
 */

/**
 * Class CreateSpendingRatesEntityTest
 * @package Magento\Rewardpoints\Test\TestCase\SpendingRates
 */
class CreateSpendingRatesEntityTest extends Injectable
{

    /**
     * @var SpendingRatesIndex
     */
    protected $spendingRatesIndex;

    /**
     * @var SpendingRatesNew
     */
    protected $spendingRatesNew;

    /**
     * @param SpendingRatesIndex $spendingRatesIndex
     * @param SpendingRatesNew $spendingRatesNew
     */
    public function __inject(SpendingRatesIndex $spendingRatesIndex, SpendingRatesNew $spendingRatesNew)
    {
        $this->spendingRatesIndex = $spendingRatesIndex;
        $this->spendingRatesNew = $spendingRatesNew;
    }

    /**
     * @param $button
     * @param Rate $rate
     * @return array
     */
    public function test($button, Rate $rate)
    {
        $this->spendingRatesIndex->open();
        $this->spendingRatesIndex->getSpendingRatesGridPageActions()->clickActionButton($button);
        $this->spendingRatesNew->getSpendingRatesForm()->fill($rate);
        $this->spendingRatesNew->getSpendingRatesFormPageActions()->save();
        return ['rate' => $rate];
    }
}