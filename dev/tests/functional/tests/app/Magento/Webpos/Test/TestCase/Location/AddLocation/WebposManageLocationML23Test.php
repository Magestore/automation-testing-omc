<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4/27/18
 * Time: 8:18 AM
 */

namespace Magento\Webpos\Test\TestCase\Location\AddLocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

/**
 * Add Location
 * Testcase ML23 - Check [Back] button
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Add Location] button
 * 2. Click on [Back] button
 *
 * Acceptance
 * 2. Back to Manage Locations page
 *
 *
 * Class WebposManageLocationML23Test
 * @package Magento\Webpos\Test\TestCase\Location\AddLocation
 */
class WebposManageLocationML23Test extends Injectable
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

    public function test()
    {
        // Steps
        $this->locationIndex->open();
        $this->locationIndex->getPageActionsBlock()->addNew();
        sleep(1);
        $this->locationNews->getFormPageActionsLocation()->back();
        sleep(1);
    }
}

