<?php
namespace Magento\Webpos\Test\Constraint\Staff;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Fixture\Location;

class AssertCheckLocationForm extends AbstractConstraint
{

    /**
     * @param WebposIndex $webposIndex
     * @param $orderId
     */
    public function processAssert(WebposIndex $webposIndex, $locations)
    {
        foreach ($locations as $location)
        {
            $webposIndex->getLoginForm()->setLocation($location['location']->getDisplayName());
            $poss = $webposIndex->getLoginForm()->getPosID()->getText();
            $poss = str_replace('--- Choose a POS ---','', $poss);
            \PHPUnit_Framework_Assert::assertEquals(
                $location['pos']->getPosName(),
                trim($poss),
                'Pos does not display correct'
            );
        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Location form is correct";
    }
}