<?php

namespace Magento\Giftvoucher\Test\Block\Account;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class Giftcodes extends Block
{
    /**
     * Search Gift Code form selector
     * 
     * @var string
     */
    protected $searchForm = '#search_gift_code_form';
    
    /**
     * Add Button selector
     * 
     * @var string
     */
    protected $addButton = '.action.add';
    
    /**
     * Click Add Button
     */
    public function add()
    {
        $this->_rootElement->find($this->addButton)->click();
    }
    
    /**
     * Search gift code
     * 
     * @param string $code
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function search($code)
    {
        $form = $this->_rootElement->find($this->searchForm);
        $form->find('input[name="qgc"]')->setValue($code);
        $form->find('button[type="submit"]')->click();
        
        $this->waitPageInit();
        
        return $this->_rootElement->find('.table-gift-codes');
    }
    
    /**
     * First Item ID of grid
     * 
     * @return string
     */
    public function getFirstItemId()
    {
        return $this->_rootElement->find('tbody td.code span')
            ->getAttribute('id');
    }
    
    /**
     * Paging: Go to next page
     * 
     * @return \Magento\Giftvoucher\Test\Block\Account\Giftcodes
     */
    public function nextPage()
    {
        $this->_rootElement->find('.pages-item-next a.next')->click();
        return $this;
    }
    
    /**
     * Paging: Go to previous page
     *
     * @return \Magento\Giftvoucher\Test\Block\Account\Giftcodes
     */
    public function prevPage()
    {
        $this->_rootElement->find('.pages-item-previous a.previous')->click();
        return $this;
    }
    
    /**
     * Paging: Go to page
     *
     * @return \Magento\Giftvoucher\Test\Block\Account\Giftcodes
     */
    public function gotoPage($page)
    {
        $this->_rootElement->find(
            './/a[@class="page"]//span[text()="' . $page . '"]',
            Locator::SELECTOR_XPATH
        )->click();
        return $this;
    }
    
    public function waitPageInit()
    {
        $this->waitForElementVisible($this->searchForm);
    }
}
