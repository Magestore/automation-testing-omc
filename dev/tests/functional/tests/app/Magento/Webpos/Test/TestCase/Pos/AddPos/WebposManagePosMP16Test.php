<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:24 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\MassAction;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

/**
 * Manage POS - Add POS
 * Testcase MP16 - Check default value of all fields
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
 * 3.
 * - General information tab:
 * + POS name: blank (text box)
 * + Location: Store address (dropdown type)
 * + Current staff: None (dropdown type)
 * + Status: Enable (dropdown type)
 * + Available for Other Staff: uncheck (checkbox)
 * + Allow POS staff to lock register: No (dropdown type)
 * - Cash denominations tab:
 * + On the grid, show all of denominations from [Manage cash denomination] page
 * - Close session tab:
 * + There is no record on the grid
 * - Current session detail tab:
 * + Show text: "There are 0 open session "
 *
 *
 * Class WebposManagePosMP16
 * @package Magento\Webpos\Test\TestCase\Pos\Filter
 */
class WebposManagePosMP16Test extends Injectable
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

    public function test()
    {
        //Steps
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $this->posIndex->getPageActionsBlock()->addNew();
        $this->posNews->getPosForm()->waitLoader();
    }
}