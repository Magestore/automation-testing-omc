<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/11/2017
 * Time: 11:10
 */

namespace Magento\Webpos\Test\TestCase\CheckVisibleForm;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\DenominationIndex;
/**
 * Class AddNewDenominationTest
 * @package Magento\Webpos\Test\TestCase\CheckVisibleForm
 */
class AddNewDenominationTest extends Injectable
{
    /**
     * Gift Template Grid Page
     *
     * @var DenominationIndex
     */
    protected $denominationIndex;

    /**
     * Injection data
     *
     * @param DenominationIndex $denominationIndex
     * @return void
     */
    public function __inject(
        DenominationIndex $denominationIndex
    ) {
        $this->denominationIndex = $denominationIndex;
    }

    /**
     * Run check visible form Check Add Gift Code entity test
     *
     * @return void
     */
    public function test()
    {
        // Steps
        $this->denominationIndex->open();
        $this->denominationIndex->getPageActionsBlock()->addNew();
    }
}