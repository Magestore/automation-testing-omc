<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 05/12/2017
 * Time: 14:07
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Form;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Check that success message is displayed after widget saved
 */
class AssertLocationErrorSaveMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param LocationNews
     * @return void
     */
    public function processAssert(LocationNews $locationNews, $idRequireds, $labelRequired)
    {
        $idRequiredsSplit = explode(', ', $idRequireds);
        foreach ($idRequiredsSplit as $fieldRequired){
            \PHPUnit_Framework_Assert::assertTrue(
                $locationNews->getLocationsForm()->isMessageRequiredDisplay($fieldRequired)->isVisible(),
                'Required '.$fieldRequired.' message is not displayed.'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $labelRequired,
                $locationNews->getLocationsForm()->getMessageRequired($fieldRequired),
                'Required '.$labelRequired.' message is not displayed.'
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
        return 'Required field is displayed.';
    }
}
