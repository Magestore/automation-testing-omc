<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 8:12 AM
 */

namespace Magento\Rewardpoints\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\Rewardpoints\Test\Page\Adminhtml\EarningRatesIndex;
use Magento\Rewardpoints\Test\Fixture\Rate;


/**
 * Class EarningRatesFormTest
 * @package Magento\Rewardpoints\Test\TestCase
 */
class EarningRatesFormTest extends Injectable
{
    /**
     * @var EarningRatesIndex
     */
    protected $earningRatesIndex;

    /**
     * @param EarningRatesIndex $earningRatesIndex
     */
    public function __inject(EarningRatesIndex $earningRatesIndex)
    {
        $this->earningRatesIndex = $earningRatesIndex;
    }

    /**
     * @param $button
     */
    public function test($button)
    {
        $this->earningRatesIndex->open();
        $this->earningRatesIndex->getEarningRatesGridPageActions()->clickActionButton($button);
    }
}