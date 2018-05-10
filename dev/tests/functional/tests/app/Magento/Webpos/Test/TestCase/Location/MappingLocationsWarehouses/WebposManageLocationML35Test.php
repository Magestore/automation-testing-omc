<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 10/05/2018
 * Time: 14:15
 */

namespace Magento\Webpos\Test\TestCase\Location\MappingLocationsWarehouses;

use Magento\InventorySuccess\Test\Fixture\Warehouse;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;

/**
 * Mapping locations - Warehouses
 * Testcase: ML35 - Check [Cancel] button
 *
 * Precondition
 * - Empty
 *
 * Steps
 * - Go to backend > Sales > Manage Locations
 * - Click on [Mapping Locations - Warehouses] button
 * - Click [Cancel] button on [Mapping Locations - Warehouse] page
 *
 * Acceptance
 * - Back to Location page
 *
 * Class WebposManageLocationML35Test
 * @package Magento\Webpos\Test\TestCase\Location\MappingLocationsWarehouses
 */
class WebposManageLocationML35Test extends Injectable
{
    /**
     * Webpos Location Index page.
     *
     * @var LocationIndex
     */
    private $locationIndex;

    /**
     * @var MappingLocationIndex
     */
    private $mappingLocationIndex;

    /**
     * @param LocationIndex $locationIndex
     * @param MappingLocationIndex $mappingLocationIndex
     */
    public function __inject(
        LocationIndex $locationIndex,
        MappingLocationIndex $mappingLocationIndex
    )
    {
        $this->locationIndex = $locationIndex;
        $this->mappingLocationIndex = $mappingLocationIndex;
    }

    public function test(Warehouse $warehouse)
    {
        //Precondition
        $warehouse->persist();
        var_dump($warehouse->getData());die();

        // Steps
        $this->locationIndex->open();
        $this->locationIndex->getMappingAction()->mappingButton();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitPageToLoad();
        $this->mappingLocationIndex->getFormPageActions()->cancel();
        $this->locationIndex->getLocationsGrid()->waitLoader();
        \PHPUnit_Framework_Assert::assertTrue(
            $this->locationIndex->getLocationsGrid()->isVisible(),
            'Location Index Page not show'
        );
    }
}

