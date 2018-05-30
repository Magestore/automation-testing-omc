<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/25/18
 * Time: 1:26 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\ReportDaily;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\SalesByLocationDaily;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Reports
 * Testcase - RP37 - Sale by location (Daily)
 *
 * Precondition
 * Create some orders at some locations on different days
 *
 * Steps
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by Staff (Daily)
 *
 * Acceptance
 * Orders just created will be updated and shown by corresponding location and date
 *
 * Class WebposSaleOderReportRP37Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\ReportDaily
 */
class WebposSaleOderReportRP37Test extends Injectable
{
    /**
     * OrderListByLocationDaily page.
     *
     * @var saleByLocationDaily
     */
    protected $saleByLocationDaily;
    /**
     * @var WebposIndex Page
     */
    protected $webposIndex;

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes']
        )->run();
    }

    /**
     * Sale by Location Daily
     *
     * @param SalesByLocationDaily $orderListByLocation
     */
    public function __inject(SalesByLocationDaily $orderListByLocation, WebposIndex $webposIndex)
    {
        $this->saleByLocationDaily = $orderListByLocation;
        $this->webposIndex = $webposIndex;
    }

    public function test(WebposIndex $webposIndex, FixtureFactory $fixtureFactory, $products, Pos $pos, Staff $staff, array $shifts)
    {
        $pos->persist();
        $staffData = $staff->getData();
        $staffData['location_id'] = $pos->getLocationId();
        $staffData['pos_ids'] = $pos->getPosId();
        $staffData['status'] = 'Enabled';
        $staff = $fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff->persist();
        $location = $pos->getDataFieldConfig('location_id')['source']->getLocation();
        //Login
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
        sleep(1);
        if ($webposIndex->getOpenSessionPopup()->isVisible()) {
            $webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        }
        $webposIndex->getMsWebpos()->waitForCMenuVisible();
        $webposIndex->getMsWebpos()->getCMenuButton()->click();
        sleep(1);
        $webposIndex->getCMenu()->checkout();
        $webposIndex->getMsWebpos()->waitCartLoader();
        $webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposAddProductToCartThenCheckoutStep',
            ['products' => $products]
        )->run();

        //Open Sale by location daily
        $this->saleByLocationDaily->open();
        $this->saleByLocationDaily->getMessagesBlock()->clickLinkInMessage('notice', 'here');
        // Steps
        $this->saleByLocationDaily->getFilterBlock()->viewsReport($shifts);
        \PHPUnit_Framework_Assert::assertContains(
            $location->getDisplayName(),
            $this->saleByLocationDaily->getReportBlock()->getLastRowLocation(),
            'Location didn\'t show correct'
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