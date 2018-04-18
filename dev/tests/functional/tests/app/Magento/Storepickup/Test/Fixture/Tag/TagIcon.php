<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/11/2017
 * Time: 5:56 PM
 */

namespace Magento\Storepickup\Test\Fixture\Tag;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;

class TagIcon extends DataSource
{
    /**
     * Fixture Factory instance.
     *
     * @var FixtureFactory
     */
    private $fixtureFactory;

    /**
     * Fixture data.
     *
     * @var array
     */
    private $fixtureData;

    /**
     * @param FixtureFactory $fixtureFactory
     * @param array $params
     * @param array $data
     */
    public function __construct(FixtureFactory $fixtureFactory, array $params, $data)
    {
        $this->fixtureFactory = $fixtureFactory;
        $this->params = $params;
        $this->fixtureData = $data;
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function getData($key = null)
    {
        $imageData = $this->fixtureData;
        if (isset($imageData) && file_exists(MTF_TESTS_PATH . $imageData)) {
            $imageData = MTF_TESTS_PATH . $imageData;
        } else {
            throw new \Exception("Image '{$imageData}'' not found on the server.");
        }
        $this->data = $imageData;

        return parent::getData($key);
    }
}