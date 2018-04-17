<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */
namespace Magento\Webpos\Test\TestCase\Location\MappingLocationsWarehouses;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;

class WebposManageLocationML36Test extends Injectable
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
     * Inject location pages.
     *
     * @param LocationIndex
     * @return void
     */
    public function __inject(
        LocationIndex $locationIndex,
        MappingLocationIndex $mappingLocationIndex
    ) {
        $this->locationIndex = $locationIndex;
        $this->mappingLocationIndex = $mappingLocationIndex;
    }

    public function test()
    {
        // Steps
        $this->locationIndex->open();
        $this->locationIndex->getMappingAction()->mappingButton();
        sleep(1);
    }
}

