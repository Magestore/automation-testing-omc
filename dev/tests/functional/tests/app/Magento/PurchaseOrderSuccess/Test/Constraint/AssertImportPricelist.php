<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/11/2017
 * Time: 16:15
 */
namespace Magento\PurchaseOrderSuccess\Test\Constraint;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\PricelistIndex;

/**
 * Class AssertPricelist
 */
class AssertImportPricelist extends AbstractConstraint
{

    public function processAssert(PricelistIndex $pricelistIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $pricelistIndex->getModalImportPricelist()->isVisible(),
            'ko giong nhau'
        );
    }

    public function toString()
    {
        return 'unknow';
    }
}
