<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:24 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\AddPos;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Manage POS - Add POS
 * Testcase MP21 - Create a POS with selecting some records on Cash Denominations grid
 *
 * Precondition
 * - There are some data records on [Manage Cash Denominations] page
 * - Setting [Need to create session before working] = Yes
 *
 * Steps
 * 1. Go to backend > Sales > Manage POS
 * 2. Click on [Add POS] button
 * 3. Fill out some fields:
 * - POS name: Pos test 3
 * - [Available for Other Staff]: check
 * - Select some records (not all) from Cash Denominations grid
 *
 * 4. Click on [Save] button
 * 5.  Login webpos by a staff who has opening session permission > choose "Pos test 3"
 * 6. Click to open [Open session] form > Observe [Coin/Bill Value] field
 *
 * Acceptance
 * 4. Save POS successfully
 * 5. Only show cash values that selected on step 2 of [Steps] column
 *
 *
 * Class WebposManagePosMP21
 * @package Magento\Webpos\Test\TestCase\Pos\Filter
 */
class WebposManagePosMP21Test extends Injectable
{
    /**
     * Pos Index Page
     *
     * @var $posIndex
     */
    private $posIndex;

    private $posNews;

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes_MS57']
        )->run();
    }

    public function __inject(PosIndex $posIndex, PosNews $posNews)
    {
        $this->posIndex = $posIndex;
        $this->posNews = $posNews;
    }

    public function test(FixtureFactory $fixtureFactory, Pos $pos, Denomination $denomination, Location $location, Staff $staff, WebposIndex $webposIndex)
    {
        //Precondition
        $location->persist();
        $staffData = $staff->getData();
        $staffData['location_id'] = $location->getLocationId();
        $staff = $fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff->persist();
        $denomination->persist();

        //Steps
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $this->posIndex->getPageActionsBlock()->addNew();
        $this->posNews->getPosForm()->waitLoader();
        $this->posNews->getPosForm()->fill($pos);
        $this->posNews->getPosForm()->setFieldByValue('page_location_id', $location->getDisplayName(), 'select');
        $this->posNews->getPosForm()->getGeneralFieldById('page_auto_join', 'checkbox')->click();
        $this->posNews->getPosForm()->getTabByTitle('Cash Denominations')->click();
        $this->posNews->getPosForm()->searchAndSelectDenominationByName($denomination->getDenominationName());
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
        $webposIndex->getSessionRegisterShift()->getClosingBalanceButton()->click();
        $webposIndex->getSessionRegisterShift()->waitForElementVisible('#popup-close-shift');

        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionSetClosingBalancePopup()->getOptionCoinBillByValue($denomination->getDenominationName())->isVisible(),
            'Denomination ' . $denomination->getDenominationName() . ' isn\'t displayed'
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