<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/11/2017
 * Time: 10:33
 */

namespace Magento\Webpos\Test\TestCase\CheckVisibleForm;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

/**
 * Class MappingLocationsWarehousesTest
 * @package Magento\Webpos\Test\TestCase\CheckVisibleForm
 */
class MappingLocationsWarehousesTest extends Injectable
{
    /**
     * Gift Template Grid Page
     *
     * @var LocationIndex $locationIndex
     */
    protected $locationIndex;

    /**
     * Injection data
     *
     * @param LocationIndex $locationIndex
     * @return void
     */
    public function __inject(
        LocationIndex $locationIndex
    )
    {
        $this->locationIndex = $locationIndex;
    }

    /**
     * Run check visible form Check Add Gift Code entity test
     *
     * @return void
     */
    public function test()
    {
        // Steps
        $this->locationIndex->open();
        $this->locationIndex->getMappingAction()->mappingButton();
    }
}