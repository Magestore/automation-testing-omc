<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:24 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\Filter;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

/**
 * Manage POS - Check Filter function
 * Testcase MP11 - Check [Apply Filters] button with full condition
 *
 * Precondition
 * - Exist at least 2 records on the grid
 *
 *
 * Steps
 * 1. Go to backend > Sales > Manage POS
 * 2. Click on [Filters] button
 * 3. Input data into all fields that match one or some records
 * 4. Click on [Apply Filter] button
 *
 * Acceptance
 * - Close Filter form
 * - The records that matching condition will be shown on the grid
 *
 * Class WebposManagePosMP11
 * @package Magento\Webpos\Test\TestCase\Pos\Filter
 */
class WebposManagePosMP11Test extends Injectable
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

    public function test(Pos $pos)
    {
        // Precondition
        $pos->persist();

        //Steps
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        return [
            'filters' => [
                'pos_name' => $pos->getPosName(),
//                'location_id' => $pos->getLocationId(),
                'status' => $pos->getStatus()
            ]
        ];
    }
}