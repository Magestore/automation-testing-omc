<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 20/02/2018
 * Time: 19:20
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Form;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Check that success message is displayed after widget saved
 */
class AssertStaffContinueEditAfterCreateStaff extends AbstractConstraint
{
    /**
     *
     * @param StaffNews $staffNews
     * @return void
     */
    public function processAssert(StaffNews $staffNews, $fields)
    {
        //Password and confimPassword is blank
        \PHPUnit_Framework_Assert::assertEquals(
            '',
            $staffNews->getStaffsForm()->getPassword(),
            'Filed password is not empty '
        );
        \PHPUnit_Framework_Assert::assertEquals(
            '',
            $staffNews->getStaffsForm()->getConfimPassword(),
            'Filed confimPassword is not empty '
        );

       //Display name, userName, emailAdress, PinCode
        \PHPUnit_Framework_Assert::assertEquals(
            $fields['display_name'],
            $staffNews->getStaffsForm()->getDisplayName(),
            'Display name is incorrect '
        );
       \PHPUnit_Framework_Assert::assertEquals(
           $fields['username'],
            $staffNews->getStaffsForm()->getUserName(),
            'User name is incorrect '
        );
       \PHPUnit_Framework_Assert::assertEquals(
           $fields['email'],
            $staffNews->getStaffsForm()->getEmailAddress(),
            'Email address is incorrect '
        );
       \PHPUnit_Framework_Assert::assertEquals(
           $fields['pin'],
            $staffNews->getStaffsForm()->getPinCode(),
            'Pin code is incorrect '
        );

       //Customer Group
        \PHPUnit_Framework_Assert::assertEquals(
            $fields['customer_group'],
            $staffNews->getStaffsForm()->getCustomerGroup(),
            'Customer group is incorrect '
        );

        //Location
        \PHPUnit_Framework_Assert::assertEquals(
            $fields['location_id'],
            $staffNews->getStaffsForm()->getLocation(),
            'Location is incorrect '
        );

        //Row
        \PHPUnit_Framework_Assert::assertEquals(
            $fields['role_id'],
            $staffNews->getStaffsForm()->getRow(),
            'Row is incorrect '
        );

        //Status
        \PHPUnit_Framework_Assert::assertEquals(
            $fields['status'],
            $staffNews->getStaffsForm()->getStatus(),
            'Status is incorrect '
        );

        //Pos
        \PHPUnit_Framework_Assert::assertEquals(
            $fields['pos_ids'],
            $staffNews->getStaffsForm()->getPos(),
            'Pos is incorrect '
        );

    }

    /**
     * Text of Required field message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Fields are incorrect';
    }
}
