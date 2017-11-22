<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\Block\Product\View;
use Magento\Mtf\Client\Locator;
use Magento\Mtf\Client\BrowserInterface;
use Magento\Mtf\Client\ElementInterface;

/**
 * Product view block on the product page.
 *
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
class Giftvoucher extends \Magento\Mtf\Block\Form
{
    public function fillForm($data) {
        $this->waitForElementVisible('#giftvoucher-info');
        $mapping = $this->dataMapping($data);
        $this->_fill($mapping);

    }


}
