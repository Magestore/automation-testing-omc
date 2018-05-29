<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/25/18
 * Time: 9:59 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\OrderDetail;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShowCorrectPriceOfChildBundleProduct extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $childProducts)
    {
        foreach ($childProducts as $childProduct) {
            $this->assertPriceProduct($webposIndex, $childProduct['name'], $childProduct['price']);
        }
    }

    private function assertPriceProduct(WebposIndex $webposIndex, $name, $price)
    {
        $actualPrice = $webposIndex->getOrderHistoryOrderViewContent()->getPriceProductByName($name);
        $actualPrice = (int)substr($actualPrice, 1);
        \PHPUnit_Framework_Assert::assertEquals(
            (int)$price,
            $actualPrice,
            'Price of ' . $name . ' product was incorrect'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Some prices was \' incorrect';
    }
}