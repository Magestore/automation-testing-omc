<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 11/22/2017
 * Time: 9:43 AM
 */
namespace Magento\FulfilReport\Test\TestCase\Order;

use Magento\Mtf\TestCase\Injectable;

/**
 * class FulfilReportCreateNewOrderTest
 * @package Magento\FulfilReport\Test\TestCase\Order
 */
class FulfilReportCreateNewOrderTest extends  Injectable
{
    /**
     * FulfilReport Index page.
     *
     * @var OrderIndex
     */
    private $orderIndex;

    /**
     * New FulfilReport page.
     *
     * @var OrderNews
     */
    private $orderNew;

    /**
     * Inject FulfilReport pages.
     *
     * @param OrderIndex $orderIndex
     * @param OrderNews $orderNew
     * @return void
     */
    public function __inject(
        OrderIndex $orderIndex,
        OrderNew $orderNew
    ) {
        $this->orderIndex = $orderIndex;
        $this->orderNew = $orderNew;
    }

    /**
     * Create FulfilReport Order test.
     *
     * @param FulfilReport $order
     * @return void
     */
    public function test()
    {
        // Steps
    }
}