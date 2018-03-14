<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */
namespace Magento\Webpos\Test\TestCase\Location\EditLocationOnGrid;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Adminhtml\Staff\Permission\AssertEditDiscountCustomPrice;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid\AssertMessageEditSuccessOnGrid;

class WebposManageLocationML16Test extends Injectable
{
    /**
     * Webpos Location Index page.
     *
     * @var LocationIndex
     */
    private $locationIndex;
    /**
     * @var AssertMessageEditSuccessOnGrid
     */
    protected $assertMessageEditSuccessOnGrid;
    /**
     * Inject location pages.
     *
     * @param LocationIndex
     * @return void
     */
    public function __inject(
        LocationIndex $locationIndex,
        AssertMessageEditSuccessOnGrid $assertMessageEditSuccessOnGrid
    ) {
        $this->locationIndex = $locationIndex;
        $this->assertMessageEditSuccessOnGrid = $assertMessageEditSuccessOnGrid;
    }

    public function test(Location $location)
    {
        // Preconditions:
        $location->persist();

        // Steps
        $this->locationIndex->open();
        $this->locationIndex->getLocationsGrid()->search(['display_name' => $location->getDisplayName()]);
        $this->locationIndex->getLocationsGrid()->getRowByDisplayName( $location->getDisplayName())->click();
        sleep(1);
        $this->locationIndex->getLocationsGrid()->setAddress('test'.$location->getAddress());
        $this->locationIndex->getLocationsGrid()->setLocationName('test'.$location->getDisplayName());
        $this->locationIndex->getLocationsGrid()->setDescription('test'.$location->getDescription());
        $this->locationIndex->getLocationsGrid()->getActionButtonEditing('Save')->click();
        $this->assertMessageEditSuccessOnGrid->processAssert($this->locationIndex, 'You have successfully saved your edits.');
        $this->locationIndex->getLocationsGrid()->waitLoader();
        sleep(1);

        $locationId = $this->locationIndex->getLocationsGrid()->getAllIds()[0];
        return ['dataDisplay' =>
            [
                'location_id' => $locationId,
                'description' => 'test'.$location->getDescription(),
                'address' => 'test'.$location->getAddress(),
                'locationName' => 'test'.$location->getDisplayName()
            ]
        ];
    }
}

