<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 22/02/2018
 * Time: 09:05
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

class AssertMessageEditSuccessOnGrid extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Assert show message edit success
     *
     * @param LocationIndex $locationIndex
     */
    public function processAssert(LocationIndex $locationIndex, LocationNews $locationNews, $page)
    {
        if($page == 'index'){
            $locationIndex->getLocationsGrid()->waitForElementVisible('#messages div[data-ui-id="messages-message-success"]');
            \PHPUnit_Framework_Assert::assertTrue(
                true,
                'Message does not display'
            );
        }elseif($page == 'new'){
            $locationNews->getMessagesBlock()->waitForElementVisible('#messages div[data-ui-id="messages-message-success"]');
            \PHPUnit_Framework_Assert::assertTrue(
                true,
                'Message does not display'
            );
        }

    }

    /**
     * Text of Required field message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Message displays';
    }
}
