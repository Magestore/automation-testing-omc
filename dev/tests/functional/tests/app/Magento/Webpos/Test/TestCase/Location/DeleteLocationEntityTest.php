<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-07 09:36:33
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-06 11:24:37
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\Location;

use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\LocationEdit;
use Magento\Mtf\TestCase\Injectable;

/**
 * Preconditions:
 * 1. Create AssertWebposCheckGUICustomerPriceCP54 Location.
 *
 * Steps:
 * 1. LoginTest to backend.
 * 2. Open Sales -> AssertWebposCheckGUICustomerPriceCP54 -> Manage Location.
 * 3. Open Location from preconditions.
 * 4. Delete.
 * 5. Perform all asserts.
 *
 * @group Location(PS)
 * @ZephyrId MAGETWO-28459
 */
class DeleteLocationEntityTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    const DOMAIN = 'CS';
    /* end tags */

    /**
     * @var LocationIndex
     */
    protected $locationIndexPage;

    /**
     * @var LocationEdit
     */
    protected $locationEditPage;

    /**
     * Preparing pages for test
     *
     * @param LocationIndex $locationIndexPage
     * @param LocationEdit $locationEditPage
     * @return void
     */
    public function __inject(
        LocationIndex $locationIndexPage,
        LocationEdit $locationEditPage
    )
    {
        $this->locationIndexPage = $locationIndexPage;
        $this->locationEditPage = $locationEditPage;
    }

    /**
     * Runs Delete Location Backend Entity test
     *
     * @param Location $location
     * @return void
     */
    public function testDeleteLocationEntity(Location $location)
    {
        // Preconditions:
        $location->persist();

        // Steps:
        $filter = ['display_name' => $location->getDisplayName()];
        $this->locationIndexPage->open();
        $this->locationIndexPage->getLocationsGrid()->searchAndOpen($filter);
        $this->locationEditPage->getFormPageActions()->delete();
        $this->locationEditPage->getModalBlock()->acceptAlert();
    }
}
