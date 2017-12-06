<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 24/11/2017
 * Time: 09:01
 */

namespace Magento\FulfilSuccess\Test\Constraint;

use Magento\FulfilSuccess\Test\Page\Adminhtml\NeedVerifyIndex;
use Magento\FulfilReport\Test\Page\Adminhtml\ReportIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertBackendGridIsAvailable
 * @package Magento\FulfilSuccess\Test\Constraint
 */
class AssertBackendGridIsAvailable extends AbstractConstraint
{
    /**
     * @param NeedVerifyIndex $needVerifyIndex
     */
    public function processAssert(NeedVerifyIndex $needVerifyIndex, $pageTitle, $names, ReportIndex $reportIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $needVerifyIndex->getGridWrap()->isVisible(),
            'On The Backend Page, the Grid Wrapper Of the Fulfilment Extension was not visible.'
        );
        if ($pageTitle != 'Dropship') {
            \PHPUnit_Framework_Assert::assertTrue(
                $needVerifyIndex->getPageMainAction()->isVisible(),
                'On The Backend Page, the Grid Header Page main action Of the Extension was not visible.'
            );
        }
        \PHPUnit_Framework_Assert::assertTrue(
            $needVerifyIndex->getGridHeader()->isVisible(),
            'On The Backend Page, the Grid Header Of the Fulfilment Extension was not visible.'
        );
        if (!empty($names)) {
            $names = explode(',', $names);
            foreach ($names as $name) {
                \PHPUnit_Framework_Assert::assertTrue(
                    $reportIndex->getPageWrapper()->getColumnByName($name)->isVisible(),
                    'On The Backend Page, any columns of the Grid Admin Of the Extension was not visible.'
                );
                sleep(0.2);
            }
        }
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'On The Backend Page, all the elements in the Grid Page Of the Extension was visible successfully.';
    }
}