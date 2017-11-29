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

/**
 * Class StorepickupSearchBox
 * @package Magento\Storepickup\Test\Block
 */
class StorepickupSearchBox extends Block
{
    /**
     * @var string
     */
    protected $searchDistance = '#search-distance';

    /**
     * @var string
     */
    protected $searchArea = '#search-area';

    /**
     * @var string
     */
    protected $searchContent = '.search-content';

    /**
     * @return mixed
     */
    public function searchDistanceIsVisible()
    {
        return $this->_rootElement->find($this->searchDistance, Locator::SELECTOR_CSS)->isVisible();
    }

    /**
     * @return mixed
     */
    public function searchAreaIsVisible()
    {
        return $this->_rootElement->find($this->searchArea, Locator::SELECTOR_CSS)->isVisible();
    }

    /**
     * @return mixed
     */
    public function searchContentIsVisible()
    {
        return $this->_rootElement->find($this->searchContent, Locator::SELECTOR_CSS)->isVisible();
    }
}