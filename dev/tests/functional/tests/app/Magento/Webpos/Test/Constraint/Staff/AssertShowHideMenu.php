<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 20/01/2018
 * Time: 12:22
 */
namespace Magento\Webpos\Test\Constraint\Staff;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShowHideMenu extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $menuItems)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(1);

        foreach ($menuItems as $item)
        {
            \PHPUnit_Framework_Assert::assertEquals(
                $item['tag'],
                $webposIndex->getCMenu()->getItem($item['id'])->isVisible(),
                'Item is incorrect'
            );
        }
        $webposIndex->getCMenu()->checkout();
        sleep(1);
    }



    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Show/hide menu is correct";
    }
}