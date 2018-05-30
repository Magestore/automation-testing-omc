<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */

namespace Magento\Webpos\Test\TestCase\Location\AddLocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

/**
 * Add Location
 * Testcase ML22 - Check [Reset] button
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Add Location] button
 * 2. Fill out correctly all fields
 * 3. Click on [Reset] button
 *
 * Acceptance
 * 3. Reset data in all fileds to default values
 *
 * Class WebposManageLocationML22Test
 * @package Magento\Webpos\Test\TestCase\Location\AddLocation
 */
class WebposManageLocationML22Test extends Injectable
{
    /**
     * Webpos Location Index page.
     *
     * @var LocationIndex
     */
    private $locationIndex;

    /**
     * @var LocationNews
     */
    private $locationNews;

    /**
     * Inject location pages.
     *
     * @param LocationIndex $locationIndex
     * @param LocationNews $locationNews
     */
    public function __inject(
        LocationIndex $locationIndex,
        LocationNews $locationNews
    )
    {
        $this->locationIndex = $locationIndex;
        $this->locationNews = $locationNews;
    }

    public function test(Location $location)
    {
        // Steps
        $this->locationIndex->open();
        $this->locationIndex->getPageActionsBlock()->addNew();
        sleep(1);
        $this->locationNews->getLocationsForm()->fill($location);
        $this->locationNews->getFormPageActionsLocation()->reset();
        sleep(1);

        return ['fields' => [
            'page_display_name' => '',
            'page_address' => '',
            'page_description' => '',
            'page_store_id' => 'Default Store View'
        ]];
    }
}

