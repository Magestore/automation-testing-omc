<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 14:39
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Form;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierNew;

class AssertNewSupplierFormIsAvailable extends AbstractConstraint
{
	public function processAssert(SupplierNew $supplierNew)
	{
	    $supplierNew->getSupplierForm()->waitPageToLoad();
	    \PHPUnit_Framework_Assert::assertTrue(
	        $supplierNew->getSupplierForm()->fieldIsVisible('[name="supplier_code"]'),
            'Supplier Code field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[name="supplier_name"]'),
            'Supplier Name field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[name="contact_name"]'),
            'Contact Person field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[name="contact_email"]'),
            'Email field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[name="description"]'),
            'Description field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[name="status"]'),
            'Status field is not visible.'
        );
        $supplierNew->getSupplierForm()->openSection('address');
        sleep(2);
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[name="telephone"]'),
            'Telephone field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[name="fax"]'),
            'Fax field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[name="street"]'),
            'Street field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[name="city"]'),
            'City field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[name="country_id"]'),
            'Country field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[data-index="region_id_input"]'),
            'Region field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[name="postcode"]'),
            'Zip/Postal Code field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[name="website"]'),
            'Website field is not visible.'
        );
        $supplierNew->getSupplierForm()->openSection('password');
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[name="new_password"]'),
            'New Password field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[name="generated_password"]'),
            'Auto-generated password field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->fieldIsVisible('[name="send_pass_to_supplier"]'),
            'Send new password to the supplier field is not visible.'
        );
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Add New Supplier Form is available";
	}
}