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
 * Testcase MP09 - Check [Apply Filters] button with no results
 *
 * Precondition
 * - Exist at least 2 records on the grid
 *
 *
 * Steps
 * 1. Go to backend > Sales > Manage POS
 * 2. Click on [Filters] button
 * 3. Input data into some fields that don't match any record
 * 4. Click on [Apply Filter] button
 *
 * Acceptance
 * Close Filter form
 * - Show message: "We couldn't find any records." on the Grid
 *
 * Class WebposManagePosMP09
 * @package Magento\Webpos\Test\TestCase\Pos\Filter
 */
class WebposManagePosMP09Test extends Injectable
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
    }
}