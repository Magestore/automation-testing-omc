<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:24 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\Filter;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

/**
 * Manage POS - Check Filter function
 * Testcase MP08 - Check [Cancel] button
 *
 * Precondition
 * - Empty
 *
 * Steps
 * 1. Go to backend > Sales > Manage POS
 * 2. Click on [Filters] button
 * 3. Click on [Cancel] button
 *
 * Acceptance
 * 1. Open Filters form including:
 * - Fileds: ID, Name, Location, Current staff, Status
 * - Buttons: Cancel, Apply Filters
 * 2. Close Filters form
 *
 * Class WebposManagePosMP08
 * @package Magento\Webpos\Test\TestCase\Pos\Filter
 */
class WebposManagePosMP08Test extends Injectable
{
    /**
     * Pos Index Page
     *
     * @var $posIndex
     */
    private $posIndex;

    public function __inject(PosIndex $posIndex)
    {
        $this->posIndex = $posIndex;
    }

    public function test()
    {
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $this->posIndex->getPosGrid()->getFilterButton()->click();
        $this->posIndex->getPosGrid()->resetFilter();
        sleep(3);
    }
}