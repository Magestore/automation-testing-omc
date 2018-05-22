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
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

/**
 * Manage POS - Add POS
 * Testcase MP18 - Create POS successfully with all required fields
 *
 * Precondition
 * - There are some locations, some staffs on the site test
 *
 * Steps
 * 1. Go to backend > Sales > Manage POS
 * 2. Click on [Add POS] button
 * 3. Input POS name to [POS Name] field Other fields: use default value
 * 4. Click on [Save] button
 *
 * Acceptance
 * 3.
 * - Create POS successfully
 * - Redirect to Manage POS page and the information of the created POS will be shown exactly on grid (Show Name, Location, Status exactly, current staff = blank)
 * - Show message: "POS was successfully saved"
 *
 * Class WebposManagePosMP18
 * @package Magento\Webpos\Test\TestCase\Pos\Filter
 */
class WebposManagePosMP18Test extends Injectable
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

    public function test(Pos $pos)
    {
        //Steps
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $this->posIndex->getPageActionsBlock()->addNew();
        $this->posNews->getPosForm()->waitLoader();
        $this->posNews->getPosForm()->fill($pos);
        $this->posNews->getFormPageActions()->save();
        $filters = [
            'pos_name' => $pos->getPosName()
        ];
        return [
            'filters' => $filters
        ];
    }
}