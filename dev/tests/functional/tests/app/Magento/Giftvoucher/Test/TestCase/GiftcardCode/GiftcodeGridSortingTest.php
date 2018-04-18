<?php
/**
 * Copyright © 2017 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\GiftcardCode;

class GiftcodeGridSortingTest extends \Magento\Ui\Test\TestCase\GridSortingTest
{
    /**
     * (non-PHPdoc)
     * @see \Magento\Ui\Test\TestCase\GridSortingTest::test()
     */
    public function test(
        $pageClass,
        $gridRetriever,
        array $columnsForSorting,
        $fixtureName = null,
        $fixtureDataSet = null,
        $itemsCount = null,
        array $steps = [],
        $fixtureAddedDataSet = null
    ) {
        // Fill grid before sorting if needed
        if ($fixtureName && $fixtureDataSet && $itemsCount && $steps) {
            $this->createItems($itemsCount, $fixtureName, $fixtureDataSet, $steps);
            if ($fixtureAddedDataSet) {
                $this->createItems($itemsCount, $fixtureName, $fixtureAddedDataSet, $steps);
            }
        }
        $result = parent::test($pageClass, $gridRetriever, $columnsForSorting);

        // Reset Filter to ID
        $grid = $this->pageFactory->create($pageClass)
            ->$gridRetriever()
            ->sortGridByField('ID');
        sleep(3); // Wait to save sort

        return $result;
    }
}
