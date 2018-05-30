<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/11/2017
 * Time: 11:05
 */

namespace Magento\Webpos\Test\TestCase\CheckVisibleForm;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

/**
 * Class AddNewPosTest
 * @package Magento\Webpos\Test\TestCase\CheckVisibleForm
 */
class AddNewPosTest extends Injectable
{
    /**
     * Gift Template Grid Page
     *
     * @var PosIndex $posIndex
     */
    protected $posIndex;

    /**
     * Injection data
     *
     * @param PosIndex $posIndex
     * @return void
     */
    public function __inject(
        PosIndex $posIndex
    )
    {
        $this->posIndex = $posIndex;
    }

    /**
     * Run check visible form Check Add Gift Code entity test
     *
     * @return void
     */
    public function test()
    {
        // Steps
        $this->posIndex->open();
        $this->posIndex->getPageActionsBlock()->addNew();
    }
}