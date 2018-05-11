<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 11/05/2018
 * Time: 16:23
 */

namespace Magento\Webpos\Test\TestCase\Location\AddLocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid\AssertLocationGridWithResult;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

/**
 * Add Location
 * Testcase ML21 - Check [Save and continue] button with filling out all fields
 *
 * Precondition
 * - Empty
 *
 * Steps
 * - Go to backend > Sales > Manage Locations
 * - Click on [Add Location] button
 * - Fill out correctly all fields [Warehouse]: Don't link to any warehouse
 * - Click on [Save and continue edit] button > create location A
 * - Go to Manage Staff > Edit staff B > Assign location A to a staff B
 * - Login webpos by staff B and select location A
 *
 * Acceptance
 * - Create Location successfully
 * - Display Edit Location page to continue edit
 * - [Warehouse]: a new warehouse is created and assigned to this Location
 * - Show message: "Location was successfully saved"
 * - There are no product on webpos
 *
 *
 * Class WebposManageLocationML21Test
 * @package Magento\Webpos\Test\TestCase\Location\AddLocation
 */
class WebposManageLocationML21Test extends Injectable
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
     * @var $_asssertGridWithResult
     */
    private $assertGridWithResult;

    /**
     * Inject location pages.
     *
     * @param LocationIndex $locationIndex
     * @param LocationNews $locationNews
     */
    public function __inject(
        LocationIndex $locationIndex,
        LocationNews $locationNews,
        AssertLocationGridWithResult $assertLocationGridWithResult

    )
    {
        $this->locationIndex = $locationIndex;
        $this->locationNews = $locationNews;
        $this->assertGridWithResult = $assertLocationGridWithResult;
    }

    public function test(Location $location)
    {
        // Steps
        $this->locationIndex->open();
        $this->locationIndex->getPageActionsBlock()->addNew();
        sleep(2);
        $this->locationNews->getLocationsForm()->fill($location);
        $this->locationNews->getFormPageActionsLocation()->saveAndContinue();
        $this->locationNews->getFormPageActionsLocation()->getButtonByname('Back')->click();
        $this->locationIndex->getLocationsGrid()->waitLoader();
    }
}

