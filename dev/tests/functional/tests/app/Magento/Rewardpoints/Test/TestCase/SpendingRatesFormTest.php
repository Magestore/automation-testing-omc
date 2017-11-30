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