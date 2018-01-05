<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 8:28 AM
 */

namespace Magento\Rewardpoints\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\Rewardpoints\Test\Page\Adminhtml\SpendingRatesIndex;

/**
 *
 * Test Flow:
 * 1. Login as admin
 * 2. Navigate to the Reward points>Spending rates
 * 3. Click on 'Add New Spending Rate' button
 * 4. Verify form add new
 *
 */

/**
 * Class SpendingRatesFormTest
 * @package Magento\Rewardpoints\Test\TestCase
 */
class SpendingRatesFormTest extends Injectable
{
    /**
     * @var SpendingRatesIndex
     */
    protected $spendingRatesIndex;

    /**
     * @param SpendingRatesIndex $spendingRatesIndex
     */
    public function __inject(SpendingRatesIndex $spendingRatesIndex)
    {
        $this->spendingRatesIndex = $spendingRatesIndex;
    }

    /**
     * @param $button
     */
    public function test($button)
    {
        $this->spendingRatesIndex->open();
        $this->spendingRatesIndex->getSpendingRatesGridPageActions()->clickActionButton($button);
    }
}