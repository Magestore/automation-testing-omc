<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-07 10:48:45
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-08 22:08:03
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\Location\IndexPage;

use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
/**
 *
 * Test Flow:
 * Preconditions:
 * 1. Create item X
 *
 * Steps:
 * 1. Open backend
 * 2. Go to  Sales > Webpos Location
 * 3. Select item X from preconditions
 * 4. Select in dropdown "Delete"
 * 5. Accept alert
 * 6. Perform all assertions according to dataset
 *
 */
class MassDeleteLocationEntityTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    const DOMAIN = 'MX';
    /* end tags */

    /**
     * Search term page
     *
     * @var LocationIndex
     */
    protected $indexPage;

    /**
     * Inject page
     *
     * @param LocationIndex $indexPage
     * @return void
     */
    public function __inject(LocationIndex $indexPage)
    {
        $this->indexPage = $indexPage;
    }

    /**
     * Run mass delete search term entity test
     *
     * @param string $locationTerms
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function test($locationTerms, FixtureFactory $fixtureFactory)
    {
        // Preconditions
        $result = [];
        $deleteLocationTerms = [];
        $locationTerms = array_map('trim', explode(',', $locationTerms));
        foreach ($locationTerms as $term) {
            list($fixture, $dataset) = explode('::', $term);
            $term = $fixtureFactory->createByCode($fixture, ['dataset' => $dataset]);
            /** @var CatalogSearchQuery $term */
            $term->persist();
            $deleteLocationTerms[] = ['webpos_staff_location' => $term->getDisplayName()];
            $result['locationTerms'][] = $term;
        }

        // Steps
        $this->indexPage->open();
        $this->indexPage->getLocationsGrid()->massaction($deleteLocationTerms, 'Delete', true);

        return $result;
    }
}
