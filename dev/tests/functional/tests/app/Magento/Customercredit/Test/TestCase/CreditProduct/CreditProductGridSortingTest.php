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
/**
 * Precondition:
 * 1. Create items
 *
 * Steps:
 * 1. Navigate to backend.
 * 2. Go to grid page
 * 3. Sort grid using provided columns
 * 5. Perform Asserts
 *
 */
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