<?php

namespace Magento\Giftvoucher\Test\TestCase\GiftcardCode;

use Magento\Mtf\TestCase\Injectable;
use Magento\Giftvoucher\Test\Fixture\Giftcode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;

/**
 * MGC001
 *
 * 1. Go to Admin > Marketing > Gift Card > Manage Gift Codes
 * 2. Display information of list of Gift Code existing in the system such as:
 *      ID, Gift Code, Initial value, Current Balance, Status, Customer, Order,
 *      Recipent, Created at, Expired at, Store view, Send To Customer, Action Created by, Action
 * 3. Display a white page " No records found" if there is no Gift Code
 * 
 * 
 * MGC033
 * 
 * Preconditions:
 * 1. Stay on Gift Code Grid page
 *
 * Steps:
 * 1. Change View to 50 records / page
 *
 * Acceptance Criteria:
 * 1. Grid changes, display 50 Gift Codes/page
 * 
 */
class ShowGiftcodeGridTest extends Injectable
{
    private $giftcodeIndex;

    public function __inject(
		GiftcodeIndex $giftcodeIndex
	) {
		$this->giftcodeIndex = $giftcodeIndex;
	}

    public function test(Giftcode $giftcode) {
        // MGC001
        $this->giftcodeIndex->open();
        
        // MGC033
        $result = [];
        
        $grid = $this->giftcodeIndex->getGiftcodeGroupGrid();
        $grid->resetFilter();
        $grid->changePerPage(20);
        $result[20] = $grid->getCountRows();
        
        $grid->changePerPage(30);
        $result[30] = $grid->getCountRows();
        
        return ['result' => $result];
    }
}
