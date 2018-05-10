<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4/27/18
 * Time: 2:47 PM
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Form;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

class AssertLocationFormDisplay extends AbstractConstraint
{
    protected $_locationNews;

    public function processAssert(LocationNews $locationNews, $page, $buttons, $title, $fields, $location = null)
    {
        $this->_locationNews = $locationNews;
        $buttons = explode(',', $buttons);
        $this->assertButtons($buttons);
        $this->assertTitle($page, $title, $location);

        $this->assertFormField($fields);
    }

    /**
     * Assert Buttons
     *
     * @param $buttons
     */
    private function assertButtons($buttons)
    {
        foreach ($buttons as $button) {
            $name = trim($button);
            \PHPUnit_Framework_Assert::assertTrue(
                $this->_locationNews->getFormPageActionsLocation()->getButtonByname($name)->isVisible(),
                'Button ' . $name . ' couldn\'t display'
            );
        }
    }

    /**
     * Assert Title
     *
     * @param $title
     */
    private function assertTitle($page, $title, $location)
    {
        $title = trim($title);
        if($page == 'new'){
            \PHPUnit_Framework_Assert::assertTrue(
                $this->_locationNews->getFormPageActionsLocation()->getTitleByName($title)->isVisible(),
                'Title ' . $title . ' couldn\'t display'
            );
        }elseif ($page = 'edit'){
            $title = $title  . ' ' .  $location->getDisplayName();
            \PHPUnit_Framework_Assert::assertTrue(
                $this->_locationNews->getFormPageActionsLocation()->getTitleByName($title)->isVisible(),
                'Title ' . $title . ' couldn\'t display'
            );
        }

    }

    private function assertFormField($fields)
    {
        foreach ($fields as $field) {
            $title = trim($field['title']);
            $required = trim('required');

            \PHPUnit_Framework_Assert::assertTrue(
                $this->_locationNews->getLocationsForm()->getFieldByName($title)->isVisible(),
                'Field ' . $title . ' couldn\'t show display'
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
        return 'Location Form Page shows correct';
    }
}