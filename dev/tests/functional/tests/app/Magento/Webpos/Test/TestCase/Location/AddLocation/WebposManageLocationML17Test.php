<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */

namespace Magento\Webpos\Test\TestCase\Location\AddLocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;


/**
 * Add Location
 * Tescase: ML17 - Click on [Save] button without filling out all fields
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Add Location] button
 * 2. Click on [Save] button
 *
 *
 * Acceptance Criteria
 * 2.
 * - Create Location unsuccessfully
 * - Show message: "This is a required field." under all required fields
 *
 * Class WebposManageLocationML17Test
 * @package Magento\Webpos\Test\TestCase\Location\AddLocation
 */
class WebposManageLocationML17Test extends Injectable
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
        $this->locationNews->getFormPageActions()->save();
        sleep(1);
    }
}

