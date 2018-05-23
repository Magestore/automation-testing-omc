<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:24 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\AddPos;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

/**
 * Manage POS - Add POS
 * Testcase MP19 - Create a POS without checking [Available for Other Staff] field
 *
 * Precondition
 * - There are some locations, some staffs on the site test
 *
 * Steps
 * 1. Go to backend > Sales > Manage POS
 * 2. Click on [Add POS] button
 * 3. Fill out some fields:
 * + POS name: Pos test
 * + Location: select a location on the list
 * + [Current staff]: Select a staff on the list
 * + [Status]: Enable
 * + [Available for Other Staff]: uncheck
 * 4. Click on [Save] button
 * 5. Go to Manage Staff > Edit a staff > Observe [POS] field
 *
 * Acceptance
 * 4.
 * - Create POS successfully
 * - Redirect to Manage POS page and the information of the created POS will be shown exactly on grid (Show Name, Location, Status exactly, current staff)
 * - Show message: "POS was successfully saved"
 * 5. The created POS (Pos test) will be shown and unselected on [POS] field and
 *
 * Class WebposManagePosMP19
 * @package Magento\Webpos\Test\TestCase\Pos\Filter
 */
class WebposManagePosMP19Test extends Injectable
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

    public function test(Pos $pos, Staff $staff)
    {
        //Precondition
        $staff->persist();

        //Steps
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $this->posIndex->getPageActionsBlock()->addNew();
        $this->posNews->getPosForm()->waitLoader();
        $this->posNews->getPosForm()->fill($pos);
        $this->posNews->getPosForm()->setFieldByValue('page_staff_id', $staff->getDisplayName(), 'select');
        $this->posNews->getFormPageActions()->save();
    }
}