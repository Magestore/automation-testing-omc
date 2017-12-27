<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 11/12/2017
 * Time: 23:05
 */
namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml\BarcodeTemplate\Grid;
use Magento\Ui\Test\TestCase\GridFilteringTest;
class FilterGridEntityForTemplateTest extends GridFilteringTest
{
    protected $gridBlock;
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
        $this->gridBlock = $gridBlock;
        $gridBlock->resetFilter();

        $filterResults = [];
        foreach ($filters as $index => $itemFilters) {
            foreach ($itemFilters as $itemFiltersName => $itemFilterValue) {
                if (substr($itemFilterValue, 0, 1) === ':') {

                    $value = $items[$index]->getData(substr($itemFilterValue, 1));
                    if ($itemFiltersName == "type") {
                        $value = explode(' ', $value)[0];
                    }
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
                $filterResults[$items[$index]->$idGetter()][$itemFiltersName] = $filteredIds;
            }
        }
        $gridBlock->resetFilter();

        return ['filterResults' => $filterResults];
    }
    public function tearDown()
    {
        $this->gridBlock->massaction([], 'Delete', true, 'Select All');
    }
}