<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/27/2017
 * Time: 8:24 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\TestCase\Quotation;

use Magento\Mtf\TestCase\Injectable;
use Magento\PurchaseOrderSuccess\Test\Fixture\Quotation;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\QuotationIndex;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\QuotationNew;

/**
 *  * Preconditions:
 * 1. Create supplier
 *
 * Test Flow:
 * 1. Login as admin
 * 2. Navigate to the Purchase Management > Quotations
 * 3. Fill out all data
 * 4. Prepare Product List
 * 5. Verify created
 *
 */

/**
 * Class CreateQuotationPurchaseEntityTest
 * @package Magento\PurchaseOrderSuccess\Test\TestCase\Quotation
 */
class CreateQuotationPurchaseEntityTest extends Injectable
{
    /**
     * @var QuotationIndex
     */
    protected $quotationIndex;

    /**
     * @var QuotationNew
     */
    protected $quotationNew;

    /**
     * @param QuotationIndex $quotationIndex
     * @param QuotationNew $quotationNew
     */
    public function __inject(QuotationIndex $quotationIndex, QuotationNew $quotationNew)
    {
        $this->quotationIndex = $quotationIndex;
        $this->quotationNew = $quotationNew;
    }

    /**
     * @param Quotation $quotation
     */
    public function test(Quotation $quotation)
    {
//        $supplier->persist();
//        throw new Exception(var_dump($quotation->getData()));
        $this->quotationIndex->open();
        $this->quotationIndex->getPageActionsBlock()->addNew();
        $this->quotationNew->getQuotationForm()->waitPageToLoad();
        $this->quotationNew->getQuotationForm()->fill($quotation);
        $this->quotationNew->getFormPageActions()->prepareProductList();
    }
}