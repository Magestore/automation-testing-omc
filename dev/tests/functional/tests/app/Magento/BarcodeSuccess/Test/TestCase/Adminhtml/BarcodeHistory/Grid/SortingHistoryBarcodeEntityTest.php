<?php
/**
 * Created by PhpStorm.
 * User: GVT
 * Date: 12/22/2017
 * Time: 1:45 PM
 */
namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml\BarcodeHistory\Grid;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\TestFramework\Inspection\Exception;
use Magento\Ui\Test\TestCase\GridSortingTest;
/**
 * Precondition:
 * 1. Create barcode
 *
 * Steps:
 * 1. Go to grid page Barcode History
 * 2. Sort grid using provided columns
 * 3. Perform Asserts
 *
 */
class SortingHistoryBarcodeEntityTest extends GridSortingTest
{

    protected $gridBlock;
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $barcode = $fixtureFactory->createByCode(
            'barcodeGenerate',
            [
                'dataset' => 'barcode',
            ]
        );
        $barcode->persist();
        return ['barcode' => $barcode];
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
            $gridBlock->waitingForLoadingMaskNotVisible();
            $sortingResults[$columnName]['firstIdAfterFirstSoring'] = $gridBlock->getItemId();
            $gridBlock->sortByColumn($columnName);
            $gridBlock->waitingForLoadingMaskNotVisible();
            $sortingResults[$columnName]['firstIdAfterSecondSoring'] = $gridBlock->getItemId();
        }
//        throw new Exception(var_dump($sortingResults));
        return ['sortingResults' => $sortingResults];
    }
}