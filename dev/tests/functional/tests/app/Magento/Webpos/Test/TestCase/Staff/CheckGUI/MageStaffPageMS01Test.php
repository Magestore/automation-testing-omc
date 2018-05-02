<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 27/04/2018
 * Time: 10:55
 */

namespace Magento\Webpos\Test\TestCase\Staff\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

/**
 * Class MageStaffPageMS01Test
 * @package Magento\Webpos\Test\TestCase\Staff\CheckGUI
 */
class MageStaffPageMS01Test extends Injectable
{
    /**
     * Webpos Staff Index page.
     *
     * @var StaffIndex
     */
    private $staffsIndex;

    /**
     * Inject Staff pages.
     *
     * @param StaffIndex $staffsIndex
     * @return void
     */
    public function __inject(
        StaffIndex $staffsIndex
    ) {
        $this->staffsIndex = $staffsIndex;
    }

    /**
     * Create Staff group test.
     *
     * @return void
     */
    public function test()
    {
        // Steps
        $this->staffsIndex->open();
    }
}

