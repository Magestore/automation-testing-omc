<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/11/2017
 * Time: 08:37
 */

namespace Magento\FulfilReport\Test\TestCase\CheckVisibleForm;

use Magento\Mtf\TestCase\Injectable;
use Magento\FulfilReport\Test\Page\Adminhtml\OrderSuccessAllOrderIndex;

/**
 * Class CheckCreateNewOrderInDefaultStoreViewTest
 * @package Magento\FulfilReport\Test\TestCase\CheckVisibleForm
 */
class CheckCreateNewOrderInDefaultStoreViewTest extends Injectable
{
    /**
     * Gift Template Grid Page
     *
     * @var OrderSuccessAllOrderIndex
     */
    protected $orderSuccessAllOrderIndex;

    /**
     * Injection data
     *
     * @param AllOrderIndex $allOrderIndex
     * @return void
     */
    public function __inject(
        OrderSuccessAllOrderIndex $orderSuccessAllOrderIndex
    ) {
        $this->orderSuccessAllOrderIndex = $orderSuccessAllOrderIndex;
    }

    /**
     * Run check visible form Check Add Gift Code entity test
     *
     * @return void
     */
    public function testCreate()
    {
        // Steps
        $this->orderSuccessAllOrderIndex->open();
        $this->orderSuccessAllOrderIndex->getOrderListingMainActions()->addNew();
    }
}