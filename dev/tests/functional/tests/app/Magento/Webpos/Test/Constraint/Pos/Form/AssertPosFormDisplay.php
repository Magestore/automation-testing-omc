<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4/27/18
 * Time: 2:47 PM
 */

namespace Magento\Webpos\Test\Constraint\Pos\Form;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

class AssertPosFormDisplay extends AbstractConstraint
{
    protected $_posNews;

    public function processAssert(PosNews $posNews, $buttons, $title, $fields)
    {
        $this->_posNews = $posNews;
        $buttons = explode(',', $buttons);
        $this->assertButtons($buttons);
        $this->assertTitle($title);

//        $this->assertFormField($fields);
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
                $this->_posNews->getFormPageActions()->getButtonByname($name)->isVisible(),
                'Button ' . $name . ' couldn\'t display'
            );
        }
    }

    /**
     * Assert Title
     *
     * @param $title
     */
    private function assertTitle($title)
    {
        $title = trim($title);
        \PHPUnit_Framework_Assert::assertTrue(
            $this->_posNews->getFormPageActions()->getTitleByName($title)->isVisible(),
            'Title ' . $title . ' couldn\'t display'
        );
    }

    private function assertFormField($fields)
    {
        foreach ($fields as $field) {
            $title = trim($field['title']);
            $required = trim('required');

            \PHPUnit_Framework_Assert::assertTrue(
                $this->_posNews->getPosForm()->getFieldByName($title)->isVisible(),
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
        return 'Pos Form Page shows correct';
    }
}