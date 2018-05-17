<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 11/05/2018
 * Time: 16:23
 */

namespace Magento\Webpos\Test\TestCase\Location\AddLocation;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid\AssertSearchExistLocationSuccess;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Handler\Pos\PosInterface;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Webpos\Test\Page\WebposIndex;

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
 * - LoginTest webpos by staff B and select location A
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
     * @var $staffIndex
     */
    private $staffIndex;

    /**
     * @var $staffNew
     */
    private $staffNew;
    /**
     * @var $posIndex
     */
    private $posIndex;
    /**
     * @var $posNew
     */
    private $posNew;

    /**
     * @var $webposIndex
     */
    private $webposIndex;

    /**
     * Inject location pages.
     *
     * @param LocationIndex $locationIndex
     * @param LocationNews $locationNews
     */

    public function __inject(
        LocationIndex $locationIndex,
        LocationNews $locationNews,
        PosIndex $posIndex,
        PosNews $posNews,
        StaffIndex $staffIndex,
        StaffNews $staffNews,
        WebposIndex $webposIndex,
        AssertSearchExistLocationSuccess $assertSearchExistLocationSuccess

    )
    {
        $this->locationIndex = $locationIndex;
        $this->locationNews = $locationNews;
        $this->posIndex = $posIndex;
        $this->posNew = $posNews;
        $this->staffIndex = $staffIndex;
        $this->staffNew = $staffNews;
        $this->webposIndex = $webposIndex;
        $this->assertGridWithResult = $assertSearchExistLocationSuccess;
    }

    public function test(FixtureFactory $fixtureFactory, Location $location, Staff $staff, Pos $pos)
    {
        //Precondition

        // Steps
        //Add Location New
        $this->locationIndex->open();
        $this->locationIndex->getPageActionsBlock()->addNew();
        $this->locationNews->getLocationsForm()->fill($location);
        $this->locationNews->getFormPageActionsLocation()->saveAndContinue();
        $this->locationNews->getFormPageActions()->back();
        $this->locationIndex->getLocationsGrid()->waitLoader();
        $this->assertGridWithResult->processAssert($this->locationIndex, $location->getData());
        sleep(1);

        //Add Pos
        $this->posIndex->open();
        $this->posIndex->getPageActionsBlock()->addNew();
        $this->posNew->getPosForm()->waitLoader();
        $this->posNew->getPosForm()->setPosName($pos->getData('pos_name'));
        $this->posNew->getPosForm()->setLocation($location->getDisplayName());
        $this->posNew->getFormPageActions()->save();
        sleep(1);

        //Edit Staff
        $this->staffIndex->open();
        $this->staffIndex->getPageActionsBlock()->addNew();
        $this->staffNew->getStaffsForm()->fill($staff);
        $this->staffNew->getFormPageActions()->save();
        $this->staffIndex->getStaffsGrid()->waitLoader();
        $this->staffIndex->getStaffsGrid()->searchAndOpen([
            'username' => $staff->getUsername()
        ]);

        $this->staffNew->getStaffsForm()->setLocation($location->getDisplayName());
        $this->staffNew->getStaffsForm()->setPos($pos->getPosName());
        $this->staffNew->getFormPageActions()->save();
        $this->staffIndex->getStaffsGrid()->waitLoader();

        //LoginTest By Staff
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff,
                'location' => $location,
                'pos' => $pos
            ]
        )->run();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="c-button--push-left"]');
        $this->webposIndex->getMsWebpos()->getCMenuButton()->click();
        sleep(1);
        $this->webposIndex->getCMenu()->checkout();
        $this->webposIndex->getCheckoutProductList()->waitProductList();
        \PHPUnit_Framework_Assert::assertTrue(
            (int)($this->webposIndex->getCheckoutProductList()->getNumberOfProducts()->getText()) > 0,
            'No Product is showed'
        );
    }
}


