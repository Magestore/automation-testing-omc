<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/5/2018
 * Time: 2:18 PM
 */

namespace Magento\Webpos\Test\TestCase\Location\ChooseLocations;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;

/**
 * Class WebposManageLocationML41Test
 * @package Magento\Webpos\Test\TestCase\Location\ChooseLocations
 */
class WebposManageLocationML41Test extends Injectable
{
    /**
     * Mapping Location Index page
     *
     * @var MappingLocationIndex
     */
    protected $mappingLocationIndex;

    /**
     * @param MappingLocationIndex $mappingLocationIndex
     */
    public function __inject(
        MappingLocationIndex $mappingLocationIndex
    ) {
        $this->mappingLocationIndex = $mappingLocationIndex;
    }

    /**
     *
     */
    public function test(
    )
    {
        $this->mappingLocationIndex->open();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitPageToLoad();
        $this->mappingLocationIndex->getMappingLocationGrid()->chooseLocations();
        $this->mappingLocationIndex->getLocationModal()->waitLoader();
        $this->mappingLocationIndex->getLocationModal()->getCancelButton()->click();
        sleep(1);
    }
}