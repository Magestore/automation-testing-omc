<?php
/**
 * Copyright © 2017 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\GiftcardProduct;

class GiftvoucherGridSortingTest extends \Magento\Ui\Test\TestCase\GridSortingTest
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
        return parent::test($pageClass, $gridRetriever, $columnsForSorting);
    }
}
