<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:33 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\Edit;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Manage POS - Edit POS
 * Testcase MP33 - Check [Current session detail] grid
 *
 * Precondition
 * - Exist at least 1 POS on the grid of Manage POS page
 * - Settings > [Need to create session before working] = Yes
 * - Login webpos by staff A > select POS A
 * -  Open a new session (session B) > place some orders
 *
 * Steps
 * 1. Go to backend > Manage POS > Edit POS A >  Click on [Current session detail] tab
 * 2. Click on [Print] button
 *
 * Acceptance
 * 2. Open X-report with correct data
 *
 * Class WebposManagePosMP33
 * @package Magento\Webpos\Test\TestCase\Pos\Edit
 */
class WebposManagePosMP33Test extends Injectable
{
    /**
     * Pos Index Page
     *
     * @var $posIndex
     */
    private $posIndex;

    /**
     * Pos New page
     *
     * @var $posNews
     */
    private $posNews;

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes_MS57']
        )->run();
    }

    /**
     * @param PosIndex $posIndex
     * @param PosNews $posNews
     */
    public function __inject(PosIndex $posIndex, PosNews $posNews)
    {
        $this->posIndex = $posIndex;
        $this->posNews = $posNews;
    }

    public function test(FixtureFactory $fixtureFactory, Pos $pos, Location $location,
                         Staff $staff, WebposIndex $webposIndex)
    {
        //Precondition
        $location->persist();
        $staffData = $staff->getData();
        $staffData['location_id'] = $location->getLocationId();
        $staff = $fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff->persist();

        //Steps
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $this->posIndex->getPageActionsBlock()->addNew();
        $this->posNews->getPosForm()->waitLoader();
        $this->posNews->getPosForm()->fill($pos);
        $this->posNews->getPosForm()->setFieldByValue('page_location_id', $location->getDisplayName(), 'select');
        $this->posNews->getPosForm()->getGeneralFieldById('page_auto_join', 'checkbox')->click();
        $this->posNews->getFormPageActions()->save();

        //login
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff,
                'location' => $location,
                'pos' => $pos,
                'hasOpenSession' => true,
                'hasWaitOpenSessionPopup' => true
            ]
        )->run();

//        Open Edit Pos Page
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $this->posIndex->getPosGrid()->searchAndOpen([
            'pos_name' => $pos->getPosName()
        ]);
        $this->posNews->getPosForm()->waitLoader();
        $this->posNews->getPosForm()->getTabByTitle('Current Sessions Detail')->click();
        $this->posNews->getPosForm()->waitForCurrentSessionLoad();
        $this->posNews->getPosForm()->getCurrentSessionButtonByTitle('Print')->click();

//        $this->posIndex->open();
//        $this->posIndex->getPosGrid()->waitLoader();
//        $this->posIndex->getPosGrid()->searchAndOpen([
//            'pos_name' => 'Post Test 2811741'
//        ]);
//        $this->posNews->getPosForm()->waitLoader();
//        $this->posNews->getPosForm()->getTabByTitle('Current Sessions Detail')->click();
//        $this->posNews->getPosForm()->waitForCurrentSessionLoad();
//        $this->posNews->getPosForm()->getCurrentSessionButtonByTitle('Print')->click();

        //

    }
    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no_MS57']
        )->run();
    }

}