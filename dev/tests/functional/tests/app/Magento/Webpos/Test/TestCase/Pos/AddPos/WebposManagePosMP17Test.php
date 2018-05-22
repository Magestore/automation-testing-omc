<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:24 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\AddPos;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

/**
 * Manage POS - Add POS
 * Testcase MP17 - Check value of each fields
 *
 * Precondition
 * - Empty
 *
 * Steps
 * 1. Go to backend > Sales > Manage POS
 * 2. Click on [Add POS] button
 * 3. Check default value of all fields
 *
 * Acceptance
 * 2.
 * - [Location]: including all of locations that get from [Manage Locations] page
 * - [Current staff]: including all of staffs that are available in this time (the staffs isn't occupying any POS)
 * - [Status]: including 2 status: Enable, Disable
 * - [Allow POS staff to lock register]: including Yes, No
 * - Cash Denominations grid: show all of data records that get from [Manage Cash Denomination] page
 *
 *
 * Class WebposManagePosMP17
 * @package Magento\Webpos\Test\TestCase\Pos\Filter
 */
class WebposManagePosMP17Test extends Injectable
{
    /**
     * Pos Index Page
     *
     * @var $posIndex
     */
    private $posIndex;

    private $posNews;

    public function __inject(PosIndex $posIndex, PosNews $posNews)
    {
        $this->posIndex = $posIndex;
        $this->posNews = $posNews;
    }

    public function test(Location $location, Staff $staff, Denomination $denomination)
    {
        //Precondition
        $location->persist();
        $staff->persist();
        $denomination->persist();

        //Steps
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $this->posIndex->getPageActionsBlock()->addNew();
        $this->posNews->getPosForm()->waitLoader();
    }
}