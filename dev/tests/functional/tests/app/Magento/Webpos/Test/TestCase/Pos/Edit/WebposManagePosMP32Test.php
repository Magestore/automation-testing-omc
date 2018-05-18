<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:32 PM
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
 * Testcase MP32 - Check [Current session detail] grid
 *
 * Precondition
 * - Exist at least 1 POS on the grid of Manage POS page
 * - Settings > [Need to create session before working] = Yes
 * - Login webpos by staff A > select POS A
 * -  Open a new session (session B) > place some orders
 *
 * Steps
 * 1. Go to backend > Manage POS > Edit POS A >  Click on [Current session detail] tab
 * 2. Click on [Set closing balance] button
 * 3. Input closing balance
 * 4. Click on [Validate closing] button
 * 5. Login webpos by staff A > select POS A > go to [Session management] page
 *
 * Acceptance
 * 2. Open [Set Closing Balance] form
 * 3. Show [Validate Closing] button
 * 4. The session B was closed
 * 5. Session B closed, system requires to open new session
 *
 * Class WebposManagePosMP32
 * @package Magento\Webpos\Test\TestCase\Pos\Edit
 */
class WebposManagePosMP32Test extends Injectable
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
                         Staff $staff, WebposIndex $webposIndex, $cashCountingQty)
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
        $this->posNews->getPosForm()->getTabByTitle('Current Sessions Detail')->click();
        $this->posNews->getPosForm()->waitForCurrentSessionLoad();
        $this->posNews->getPosForm()->getCurrentSessionButtonByTitle('Set Closing Balance')->click();
        $this->posNews->getPosForm()->waitForElementVisible('#popup-close-shift');
        $this->posNews->getPosForm()->setCashCountingQuanty($cashCountingQty);
        $this->posNews->getPosForm()->saveClosingBalance();
        $this->posNews->getPosForm()->waitForElementVisible('#set-closing-balance-reason');
        $this->posNews->getPosForm()->confirmReason()->click();
        $this->posNews->getPosForm()->waitForElementNotVisible('#set-closing-balance-reason');
        $this->posNews->getPosForm()->validateClosing('Validate Closing');
        $this->posNews->getPosForm()->waitForLoaderHidden();

        //login
        $webposIndex->open();
        $webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
        $webposIndex->getMsWebpos()->waitForElementVisible('#popup-open-shift');

        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getMsWebpos()->getOpenShipPopup()->isVisible(),
            'Session isn\'t closed'
        );

    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no_MS57']
        )->run();
    }

}