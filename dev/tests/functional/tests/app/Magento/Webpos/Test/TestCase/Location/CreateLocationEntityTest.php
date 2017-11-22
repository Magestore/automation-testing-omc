<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-07 08:47:13
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-06 11:24:22
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\Location;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

/**
 * Steps:
 * 1. Log in to Admin.
 * 2. Open the Sales -> Location Manage page.
 * 3. Click the "New Location" button.
 * 4. Enter data according to a data set. For each variation, the Location must have unique identifiers.
 * 5. Click the "Save Location Group" button.
 * 6. Verify the Location group saved successfully.
 */
class CreateLocationEntityTest extends Injectable
{
    /**
     * Webpos Location Index page.
     *
     * @var LocationIndex
     */
    private $locationsIndex;

    /**
     * New Location Group page.
     *
     * @var LocationNews
     */
    private $locationsNew;

    /**
     * Inject Location pages.
     *
     * @param LocationIndex $locationsIndex
     * @param LocationNews $locationsNew
     * @return void
     */
    public function __inject(
        LocationIndex $locationsIndex,
        LocationNews $locationsNew
    ) {
        $this->locationsIndex = $locationsIndex;
        $this->locationsNew = $locationsNew;
    }

    /**
     * Create Location group test.
     *
     * @param Location $location
     * @return void
     */
    public function test(Location $location)
    {
        // Steps
        $this->locationsIndex->open();
        $this->locationsIndex->getPageActionsBlock()->addNew();
        $this->locationsNew->getLocationsForm()->fill($location);
        $this->locationsNew->getFormPageActions()->save();
    }
}
