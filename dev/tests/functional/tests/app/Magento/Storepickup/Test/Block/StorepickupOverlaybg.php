<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/28/2017
 * Time: 10:32 AM
 */

namespace Magento\Storepickup\Test\Block;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class StorepickupOverlaybg
 * @package Magento\Storepickup\Test\Block
 */
class StorepickupOverlaybg extends Block
{
    /**
     *
     */
    public function waitingForNotVisible()
    {
        $this->waitForElementNotVisible('.overlay-bg', Locator::SELECTOR_CSS);
    }
}
