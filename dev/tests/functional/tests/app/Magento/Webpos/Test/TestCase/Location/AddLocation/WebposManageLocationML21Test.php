<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */
namespace Magento\Webpos\Test\TestCase\Location\AddLocation;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid\AssertLocationGridWithResult;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

class WebposManageLocationML21Test extends Injectable
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
     * @var $_asssertGridWithResult
     */
    private $asssertGridWithResult;

    /**
     * Inject location pages.
     *
     * @param LocationIndex $locationIndex
     * @param LocationNews $locationNews
     */
    public function __inject(
        LocationIndex $locationIndex,
        LocationNews $locationNews,
        AssertLocationGridWithResult $assertLocationGridWithResult

    ) {
        $this->locationIndex = $locationIndex;
        $this->locationNews = $locationNews;
        $this->asssertGridWithResult = $assertLocationGridWithResult;
    }

    public function test(Location $location)
    {
        // Steps
        $this->locationIndex->open();
        $this->locationIndex->getPageActionsBlock()->addNew();
        sleep(2);
        $this->locationNews->getLocationsForm()->fill($location);
        $this->locationNews->getFormPageActionsLocation()->saveAndContinue();
        $this->locationNews->getFormPageActionsLocation()->getButtonByname('Back')->click();
        $this->locationIndex->getLocationsGrid()->waitLoader();
        $this->locationIndex->getLocationsGrid()->search([
            'display_name' => $location->getDisplayName()
        ]);
        $this->locationIndex->getLocationsGrid()->waitLoader();
        sleep(3);
        $this->asssertGridWithResult->processAssert($this->locationIndex);
    }
}

