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

class WebposManageLocationML34Test extends Injectable
{
    /**
     * Webpos Location Index page.
     *
     * @var LocationIndex
     */
    private $locationIndex;

    /**
     * Inject location pages.
     *
     * @param LocationIndex
     * @return void
     */
    public function __inject(
        LocationIndex $locationIndex
    ) {
        $this->locationIndex = $locationIndex;
    }

    public function test()
    {
        // Steps
        $this->locationIndex->open();
        $this->locationIndex->getMappingAction()->mappingButton();
        sleep(1);
    }
}

