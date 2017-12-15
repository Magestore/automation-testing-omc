<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/4/2017
 * Time: 10:42 AM
 */

namespace Magento\Customercredit\Test\TestCase\CreditProduct;

use Magento\Ui\Test\TestCase\GridSortingTest;
use Magento\Mtf\Fixture\FixtureInterface;

class CreditProductGridSortingTest extends GridSortingTest
{
    protected function processSteps(FixtureInterface $item, $steps)
    {
        if (!is_array($steps) && $steps != '-') {
            $steps = [$steps];
        } elseif ($steps == '-') {
            $steps = [];
        }
        foreach ($steps as $step) {
            $processStep = $this->objectManager->create($step);
            $processStep->run();
        }
    }
}