<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\GiftcardProduct;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftvoucherProductIndex;
use Magento\Mtf\TestCase\Injectable;

class ShowGiftvoucherGridTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    const DOMAIN = 'PS';
    const TEST_TYPE = 'acceptance_test, extended_acceptance_test';
    /* end tags */


    protected $giftvoucherProductIndex;


    public function __inject(GiftvoucherProductIndex $giftvoucherProductIndex)
    {
        $this->giftvoucherProductIndex = $giftvoucherProductIndex;
    }


    public function test()
    {
        //Steps:
        $this->giftvoucherProductIndex->open();
    }
}
