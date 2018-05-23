<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/21/18
 * Time: 4:08 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\NewFeature;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Mange Session - Option to remove the session history from webpos (or show last 7 days/ 30 days.....)
 * Testcase - TC0009 Check showing session history in last 30 days
 *
 * Precondition
 * Loged into backend
 * - In the settings of webpos, set config the field : Need to create session before working = yes (path: On admin sidebar-> tap on Sales -> under webpos -> choose Setttings)
 *
 * Steps
 * 1. In webpos settings, set config the field: Limit days to show session history = last 30 days
 * 2. Login webpos with staff account
 * 3. Go to Session Management page
 * 4. Observe the sessions listed on
 *
 * Acceptance
 * Show the sessions in last 30 days
 *
 *
 * Class WebposManageSessionTC009
 * @package Magento\Webpos\Test\TestCase\SessionManagement\NewFeature
 */
class WebposManageSessionTC009Test extends Injectable
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
            ['configData' => 'create_section_before_working_yes,
            create_show_history_conducted_within_30_day']
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
                         Staff $staff, WebposIndex $webposIndex, $showSessionHistoryTime)
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

//        login
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

        $webposIndex->getSessionRegisterShift()->waitLoader();
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionRegisterShift()->getShiftListingHeaderByTitle($showSessionHistoryTime)->isVisible(),
            'Title shift header wasn\'t show correctly'
        );
    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no']
        )->run();
    }

}