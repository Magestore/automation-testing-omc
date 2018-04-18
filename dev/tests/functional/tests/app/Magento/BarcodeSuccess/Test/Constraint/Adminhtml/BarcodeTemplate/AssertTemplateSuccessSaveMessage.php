<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml\BarcodeTemplate;

use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeTemplate\BarcodeTemplateIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Check that success message is displayed after widget saved
 */
class AssertTemplateSuccessSaveMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Text value to be checked
     */
    const SUCCESS_MESSAGE_SAVE = 'The template has been saved successfully';
    const SUCCESS_MESSAGE_CHANGESTATUS = 'The template(s) status has been saved successfully';
    const SUCCESS_MESSAGE_DELETE = 'The template(s) has been deleted successfully';


    /**
     * Assert that success message is displayed after template saved
     *
     * @param BarcodeTemplateIndex $barcodeTemplateIndex
     * @return void
     */
    public function processAssert(BarcodeTemplateIndex $barcodeTemplateIndex, $massAction = null)
    {
        if($massAction == null){
            $actualMessage = $barcodeTemplateIndex->getMessagesBlock()->getSuccessMessage();
            \PHPUnit_Framework_Assert::assertEquals(
                self::SUCCESS_MESSAGE_SAVE,
                $actualMessage,
                'Wrong success message is displayed.'
            );
        }else{
            switch ($massAction){
                case "Delete":
                {$actualMessage = $barcodeTemplateIndex->getMessagesBlock()->getSuccessMessage();
                    \PHPUnit_Framework_Assert::assertEquals(
                        self::SUCCESS_MESSAGE_DELETE,
                        $actualMessage,
                        'Wrong success message is displayed.'
                    );

                    break;
                }
                case "Change status":
                {$actualMessage = $barcodeTemplateIndex->getMessagesBlock()->getSuccessMessage();
                    \PHPUnit_Framework_Assert::assertEquals(
                        self::SUCCESS_MESSAGE_CHANGESTATUS,
                        $actualMessage,
                        'Wrong success message is displayed.'
                    );

                    break;
                }
            }
        }

    }

    /**
     * Text of Created Widget Success Message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Template success create message is present.';
    }
}
