<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/24/18
 * Time: 11:03 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\OrderDetail;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShowCorrectBundleProductOrder extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $productInfo)
    {
        $webposIndex->getOrderHistoryOrderViewContent()->waitForElementVisible('.order-info');
        $productTitles = array_map('trim', explode(',', $productInfo));
        foreach ($productTitles as $title) {
            $this->assertProductInfo($webposIndex, $title);
        }
    }

    public function assertProductInfo(WebposIndex $webposIndex, $title)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryOrderViewContent()->getProductTitleByName($title)->isVisible(),
            $title . ' wasn\'t displayed in Order View'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Bundle products Order was showed correctly';
    }
}