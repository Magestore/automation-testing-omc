<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/21/2017
 * Time: 11:14 AM
 */

namespace Magento\Customercredit\Test\TestCase\CustomerUsingCredit;

use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Ui\Test\TestCase\GridFilteringTest;

/**
 * Precondition:
 * 1. Create item
 *
 * Steps:
 * 1. Navigate to backend Store Credit > Manage Customers Using Credit.
 * 2. Filter grid using provided columns
 * 3. Perform Asserts
 *
 */
class CustomerUsingCreditGridFilteringTest extends GridFilteringTest
{
    public function test(
        $pageClass,
        $gridRetriever,
        $idGetter,
        array $filters,
        $fixtureName,
        $itemsCount,
        array $steps = [],
        $fixtureDataSet = null,
        $idColumn = null
    ) {
        $items = $this->createItems($itemsCount, $fixtureName, $fixtureDataSet, $steps);
        $page = $this->pageFactory->create($pageClass);

        // Steps
        $page->open();
        /** @var DataGrid $gridBlock */
        $gridBlock = $page->$gridRetriever();
        $gridBlock->resetFilter();

        $filterResults = [];
        foreach ($filters as $index => $itemFilters) {
            foreach ($itemFilters as $itemFiltersName => $itemFilterValue) {
                if (substr($itemFilterValue, 0, 1) === ':') {
                    $value = $items[$index]->getCustomer()[(substr($itemFilterValue, 1))];
                } else {
                    $value = $itemFilterValue;
                }
                $gridBlock->search([$itemFiltersName => $value]);
                $idsInGrid = $gridBlock->getAllIds();
                if ($idColumn) {
                    $filteredTargetIds = [];
                    foreach ($idsInGrid as $filteredId) {
                        $filteredTargetIds[] = $gridBlock->getColumnValue($filteredId, $idColumn);
                    }
                    $idsInGrid = $filteredTargetIds;
                }
                $filteredIds = $this->getActualIds($idsInGrid, $items, $idGetter);
                $filterResults[$items[$index]->getCustomer()['entity_id']][$itemFiltersName] = $filteredIds;
            }
        }

        return ['filterResults' => $filterResults];
    }

    /**
     * @param string[] $ids
     * @param FixtureInterface[] $items
     * @param string $idGetter
     * @return string[]
     */
    protected function getActualIds(array $ids, array $items, $idGetter)
    {
        $actualIds = [];
        foreach ($items as $item) {
            if (in_array($item->getCustomer()['entity_id'], $ids)) {
                $actualIds[] = $item->getCustomer()['entity_id'];
            }
        }
        return  $actualIds;
    }
}