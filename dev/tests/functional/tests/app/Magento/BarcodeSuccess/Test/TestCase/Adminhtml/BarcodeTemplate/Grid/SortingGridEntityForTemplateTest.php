<?php
/**
 * Created by PhpStorm.
 * User: GVT
 * Date: 12/22/2017
 * Time: 1:45 PM
 */
namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml\BarcodeTemplate\Grid;
use Magento\BarcodeSuccess\Test\Fixture\TemplateBarcode;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Ui\Test\TestCase\GridSortingTest;
class SortingGridEntityForTemplateTest extends GridSortingTest
{

    protected $gridBlock;
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $templateBarcode = $fixtureFactory->createByCode('templateBarcode', ['dataset'=>'template2']);
        $templateBarcode->persist();
        return ['templateBarcode' => $templateBarcode];
    }
    public function test(
        $pageClass,
        $gridRetriever,
        array $columnsForSorting,
        $fixtureName = null,
        $fixtureDataSet = null,
        $itemsCount = null,
        array $steps = []
    ) {
        // Fill grid before sorting if needed
        if ($fixtureName && $fixtureDataSet && $itemsCount && $steps) {
            $this->createItems($itemsCount, $fixtureName, $fixtureDataSet, $steps);
        }

        $page = $this->pageFactory->create($pageClass);

        // Steps
        $page->open();
        /** @var DataGrid $gridBlock */
        $gridBlock = $page->$gridRetriever();
        $this->gridBlock = $gridBlock;
        $gridBlock->resetFilter();

        $sortingResults = [];
        foreach ($columnsForSorting as $columnName) {
            $gridBlock->resetFilter();
            $gridBlock->sortByColumn($columnName);
            $sortingResults[$columnName]['firstIdAfterFirstSoring'] = $gridBlock->getFirstItemId();
            $gridBlock->sortByColumn($columnName);
            $sortingResults[$columnName]['firstIdAfterSecondSoring'] = $gridBlock->getFirstItemId();
        }

        return ['sortingResults' => $sortingResults];
    }
    public function tearDown()
    {
        $this->gridBlock->massaction([], 'Delete', true, 'Select All');
    }
}