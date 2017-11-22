<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-08 13:52:26
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-08 22:09:22
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\Pos;

use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

class MassDeletePosEntityTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    const DOMAIN = 'MX';
    /* end tags */

    /**
     * Search term page
     *
     * @var PosIndex
     */
    protected $indexPage;

    /**
     * Inject page
     *
     * @param PosIndex $indexPage
     * @return void
     */
    public function __inject(PosIndex $indexPage)
    {
        $this->indexPage = $indexPage;
    }

    /**
     * Run mass delete pos term entity test
     *
     * @param string $posTerms
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function test($posTerms, FixtureFactory $fixtureFactory)
    {
        // Preconditions
        $result = [];
        $deletePosTerms = [];
        $posTerms = array_map('trim', explode(',', $posTerms));
        foreach ($posTerms as $term) {
            list($fixture, $dataset) = explode('::', $term);
            $term = $fixtureFactory->createByCode($fixture, ['dataset' => $dataset]);
            /** @var CatalogSearchQuery $term */
            $term->persist();
            $deletePosTerms[] = ['webpos_pos' => $term->getPosName()];
            $result['posTerms'][] = $term;
        }

        // Steps
        $this->indexPage->open();
        $this->indexPage->getPosGrid()->massaction($deletePosTerms, 'Delete', true);

        return $result;
    }
}
