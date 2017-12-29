<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/6/2017
 * Time: 2:54 PM
 */

namespace Magento\Webpos\Test\TestCase\Denomination;

use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Page\Adminhtml\DenominationIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

/**
 * Class DenominationMassDeleteTest
 * @package Magento\Webpos\Test\TestCase\Denomination
 */
/**
 *
 * Test Flow:
 * Preconditions:
 * 1. Create item X
 *
 * Steps:
 * 1. Open backend
 * 2. Go to  Sales > Webpos Cash Denomination
 * 3. Select item X from preconditions
 * 4. Select in dropdown "Delete"
 * 5. Accept alert
 * 6. Perform all assertions according to dataset
 *
 */
class DenominationMassDeleteTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    const DOMAIN = 'MX';
    /* end tags */

    /**
     * Search term page
     *
     * @var DenominationIndex
     */
    protected $indexPage;

    /**
     * @param DenominationIndex $indexPage
     */
    public function __inject(DenominationIndex $indexPage)
    {
        $this->indexPage = $indexPage;
    }


    public function test($denominationTerms, FixtureFactory $fixtureFactory)
    {
        // Preconditions
        $result = [];
        $deleteDenominationTerms = [];
        $denominationTerms = array_map('trim', explode(',', $denominationTerms));
        foreach ($denominationTerms as $term) {
            list($fixture, $dataset) = explode('::', $term);
            $term = $fixtureFactory->createByCode($fixture, ['dataset' => $dataset]);
            /** @var CatalogSearchQuery $term */
            $term->persist();
            $deleteDenominationTerms[] = ['webpos_cash_denomination' => $term->getDenominationName()];
            $result['$denominationTerms'][] = $term;
        }

        // Steps
        $this->indexPage->open();
        $this->indexPage->getDenominationsGrid()->massaction($deleteDenominationTerms, 'Delete', true);

        return $result;
    }
}