<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:29 PM
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
 * Testcase MP29 - Check [Current session detail] grid
 *
 * Precondition
 * - Exist at least 1 POS on the grid of Manage POS page
 * - Settings > [Need to create session before working] = Yes
 *
 * Steps
 * 1. Login webpos by staff A > select POS A
 * 2. Open a new session (session B) > place order
 * 3. Click on [Closed sessions] tab
 * 4. Click on [Current session detail] tab
 *
 * Acceptance
 * 3. On [Closed sessions] tab, information of the session B will be shown exactly and [Closed at] column is blank
 * 4. Show exactly all information of session B:
 * + Time create
 * + Open balance
 * + Transactions
 * + Theoretical Closing balance
 * + Real closing Balance
 * + Difference
 * 4. buttons: Refresh, Put money in, Take money out, Set closing balance, Print
 *
 *
 * Class WebposManagePosMP29
 * @package Magento\Webpos\Test\TestCase\Pos\Edit
 */
class WebposManagePosMP29Test extends Injectable
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
                         Staff $staff)
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

        //Open Edit Pos Page
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $this->posIndex->getPosGrid()->searchAndOpen([
            'pos_name' => $pos->getPosName()
        ]);
        $this->posNews->getPosForm()->waitLoader();
        }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no_MS57']
        )->run();
    }

}