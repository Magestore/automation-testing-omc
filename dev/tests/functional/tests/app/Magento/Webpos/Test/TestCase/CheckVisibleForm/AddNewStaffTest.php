<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/11/2017
 * Time: 10:58
 */

namespace Magento\Webpos\Test\TestCase\CheckVisibleForm;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

/**
 * Class AddNewStaffTest
 * @package Magento\Webpos\Test\TestCase\CheckVisibleForm
 */
class AddNewStaffTest extends Injectable
{
    /**
     * Gift Template Grid Page
     *
     * @var StaffIndex $staffIndex
     */
    protected $staffIndex;

    /**
     * Injection data
     *
     * @param StaffIndex $staffIndex
     * @return void
     */
    public function __inject(
        StaffIndex $staffIndex
    )
    {
        $this->staffIndex = $staffIndex;
    }

    /**
     * Run check visible form Check Add Gift Code entity test
     *
     * @return void
     */
    public function test()
    {
        // Steps
        $this->staffIndex->open();
        $this->staffIndex->getPageActionsBlock()->addNew();
    }
}