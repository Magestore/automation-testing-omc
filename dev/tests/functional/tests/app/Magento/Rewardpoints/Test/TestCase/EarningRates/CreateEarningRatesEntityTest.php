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
use Magento\Rewardpoints\Test\Fixture\Rate;


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
     * @param Rate $rate
     * @return array
     */
    public function test($button, Rate $rate)
    {
        $this->earningRatesIndex->open();
        $this->earningRatesIndex->getEarningRatesGridPageActions()->clickActionButton($button);
        $this->earningRatesNew->getEarningRatesForm()->fill($rate);
        $this->earningRatesNew->getEarningRatesFormPageActions()->save();
        return ['rate' => $rate];
    }
}