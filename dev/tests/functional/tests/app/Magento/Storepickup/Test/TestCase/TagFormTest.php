<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 9:13 AM
 */

namespace Magento\Storepickup\Test\TestCase;

use Magento\Customercredit\Test\Fixture\CustomerUseCredit;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Setup\Exception;
use Magento\Storepickup\Test\Fixture\StorepickupHoliday;
use Magento\Storepickup\Test\Fixture\StorepickupSchedule;
use Magento\Storepickup\Test\Fixture\StorepickupSpecialday;
use Magento\Storepickup\Test\Fixture\StorepickupStore;
use Magento\Storepickup\Test\Fixture\StorepickupTag;
use Magento\Storepickup\Test\Page\Adminhtml\TagIndex;

/**
 * Steps:
 * 1. LoginTest to the backend.
 * 2. Navigate to Store Pickup > Manage Tag.
 * 3. Click to Add New Tag.
 * 4. Perform appropriate assertions.
 *
 */
class TagFormTest extends Injectable
{
    /**
     * @var TagIndex
     */
    protected $tagIndex;

    /**
     * @param TagIndex $tagIndex
     */
    public function __inject(TagIndex $tagIndex)
    {
        $this->tagIndex = $tagIndex;
    }

//    public function __prepare(CustomerUseCredit $customerUseCredit)
//    {
////        throw new Exception(var_dump($customerUseCredit->getData()));
//        $customerUseCredit->persist();
//    }

    /**
     * @param $button
     */
    public function test($button)
    {
        $this->tagIndex->open();
        $this->tagIndex->getTagGridPageActions()->clickActionButton($button);
        $this->tagIndex->getTagGrid()->waitingForGridNotVisible();
    }
}