<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/28/2017
 * Time: 2:30 PM
 */

namespace Magento\PurchaseOrderSuccess\Test\TestCase\Quotation;

use Magento\PurchaseOrderSuccess\Test\Fixture\Quotation;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\QuotationView;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\QuotationIndex;
use Magento\Mtf\TestCase\Injectable;
use Magento\Mtf\Fixture\FixtureFactory;

/**
 * Precondition:
 * 1. Quotation is created.
 *
 * Steps:
 * 1. Login to backend.
 * 2. Navigate to Purchase Management > Quotations
 * 3. Select a quotation in the grid.
 * 4. Edit test value(s) according to dataset.
 * 5. Click "Save".
 * 6. Perform asserts.
 *
 */
class UpdateQuotationPurchaseEntityTest extends Injectable
{
    /**
     * @var QuotationIndex
     */
    protected $quotationIndex;

    /**
     * @var QuotationView
     */
    protected $viewQuotationPage;

    /**
     * @param QuotationIndex $quotationIndex
     * @param QuotationView $quotationView
     */
    public function __inject(QuotationIndex $quotationIndex, QuotationView $quotationView)
    {
        $this->quotationIndex = $quotationIndex;
        $this->viewQuotationPage = $quotationView;
    }

    /**
     * @param Quotation $initialQuotation
     * @param Quotation $quotation
     * @return array
     */
    public function test(
        Quotation $initialQuotation,
        Quotation $quotation
    ) {
        // Preconditions
        $initialQuotation->persist();

        // Steps
        $filter = ['supplier_id' => $initialQuotation->getData('supplier_id')];

        $this->quotationIndex->open();
        $this->quotationIndex->getQuotationGrid()->searchAndOpen($filter);
        $this->viewQuotationPage->getQuotationViewForm()->fill($quotation);
        $this->viewQuotationPage->getFormPageActions()->save();

        return ['supplier_id' => $initialQuotation->getSupplierId()];
    }

}