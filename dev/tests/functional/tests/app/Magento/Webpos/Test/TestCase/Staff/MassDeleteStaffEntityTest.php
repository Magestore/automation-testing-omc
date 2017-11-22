<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-08 08:16:35
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-08 22:14:20
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\Staff;

use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

class MassDeleteStaffEntityTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    const DOMAIN = 'MX';
    /* end tags */

    /**
     * Search term page
     *
     * @var StaffIndex
     */
    protected $indexPage;

    /**
     * Inject page
     *
     * @param StaffIndex $indexPage
     * @return void
     */
    public function __inject(StaffIndex $indexPage)
    {
        $this->indexPage = $indexPage;
    }

    /**
     * Run mass delete search term entity test
     *
     * @param string $staffTerms
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function test($staffTerms, FixtureFactory $fixtureFactory)
    {
        // Preconditions
        $result = [];
        $deleteStaffTerms = [];
        $staffTerms = array_map('trim', explode(',', $staffTerms));
        foreach ($staffTerms as $term) {
            list($fixture, $dataset) = explode('::', $term);
            $term = $fixtureFactory->createByCode($fixture, ['dataset' => $dataset]);
            /** @var CatalogSearchQuery $term */
            $term->persist();
            $deleteStaffTerms[] = ['webpos_staff' => $term->getEmail()];
            $result['staffTerms'][] = $term;
        }

        // Steps
        $this->indexPage->open();
        $this->indexPage->getStaffsGrid()->massaction($deleteStaffTerms, 'Delete', true);

        return $result;
    }
}
