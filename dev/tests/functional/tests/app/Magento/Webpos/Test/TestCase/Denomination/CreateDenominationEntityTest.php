<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/6/2017
 * Time: 4:19 PM
 */

namespace Magento\Webpos\Test\TestCase\Denomination;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Page\Adminhtml\DenominationIndex;
use Magento\Webpos\Test\Page\Adminhtml\DenominationNews;
/**
 * Class CreateDenominationEntityTest
 * @package Magento\Webpos\Test\TestCase\Denomination
 */
/**
 * Steps:
 * 1. Log in to Admin.
 * 2. Open the Sales -> Denomination Manage page.
 * 3. Click the "New Denomination" button.
 * 4. Enter data according to a data set. For each variation, the Location must have unique identifiers.
 * 5. Click the "Save" button.
 * 6. Verify the Denomination group saved successfully.
 */
class CreateDenominationEntityTest extends Injectable
{
    /**
     * Webpos Denomination Index page.
     *
     * @var DenominationIndex
     */
    private $denominationIndex;
    /**
     * New Denominaiton Group page.
     *
     * @var DenominationNews
     */
    private $denominationNews;

    /**
     * @param DenominationIndex $denominationIndex
     * @param DenominationNews $denominationNews
     */
    public function __inject(
        DenominationIndex $denominationIndex,
        DenominationNews $denominationNews
    ) {
        $this->denominationIndex = $denominationIndex;
        $this->denominationNews = $denominationNews;
    }

    /**
     * Create Denomination group test.
     *
     * @param Denomination $denomination
     * @return void
     */
    public function test(Denomination $denomination)
    {
        // Steps
        $this->denominationIndex->open();
        $this->denominationIndex->getPageActionsBlock()->addNew();
        $this->denominationNews->getDenominationsForm()->fill($denomination);
        $this->denominationNews->getFormPageActions()->save();
    }
}