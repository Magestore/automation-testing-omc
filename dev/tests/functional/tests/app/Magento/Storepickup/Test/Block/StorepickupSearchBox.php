<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/28/2017
 * Time: 8:40 AM
 */

namespace Magento\Storepickup\Test\Block;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class StorepickupSearchBox extends Block
{
    protected $searchDistance = '#search-distance';

    protected $searchArea = '#search-area';

    protected $searchContent = '.search-content';

    public function searchDistanceIsVisible()
    {
        return $this->_rootElement->find($this->searchDistance, Locator::SELECTOR_CSS)->isVisible();
    }

    public function searchAreaIsVisible()
    {
        return $this->_rootElement->find($this->searchArea, Locator::SELECTOR_CSS)->isVisible();
    }

    public function searchContentIsVisible()
    {
        return $this->_rootElement->find($this->searchContent, Locator::SELECTOR_CSS)->isVisible();
    }
}