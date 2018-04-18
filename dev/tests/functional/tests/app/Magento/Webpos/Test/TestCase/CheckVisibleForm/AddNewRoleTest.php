<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/11/2017
 * Time: 11:02
 */

namespace Magento\Webpos\Test\TestCase\CheckVisibleForm;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
/**
 * Class AddNewRoleTest
 * @package Magento\Webpos\Test\TestCase\CheckVisibleForm
 */
class AddNewRoleTest extends Injectable
{
    /**
     * Gift Template Grid Page
     *
     * @var WebposRoleIndex
     */
    protected $webposRoleIndex;

    /**
     * Injection data
     *
     * @param WebposRoleIndex $staffIndex
     * @return void
     */
    public function __inject(
        WebposRoleIndex $webposRoleIndex
    ) {
        $this->webposRoleIndex = $webposRoleIndex;
    }

    /**
     * Run check visible form Check Add Gift Code entity test
     *
     * @return void
     */
    public function test()
    {
        // Steps
        $this->webposRoleIndex->open();
        $this->webposRoleIndex->getPageActionsBlock()->addNew();
    }
}