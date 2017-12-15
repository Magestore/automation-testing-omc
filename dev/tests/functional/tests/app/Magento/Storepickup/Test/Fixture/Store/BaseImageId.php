<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/11/2017
 * Time: 8:28 AM
 */

namespace Magento\Storepickup\Test\Fixture\Store;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;

class BaseImageId extends DataSource
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
    public function __construct(FixtureFactory $fixtureFactory, array $params, $data = [])
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
        foreach ($this->fixtureData as &$imageData) {
            if (isset($imageData['file']) && file_exists(MTF_TESTS_PATH . $imageData['file'])) {
                $imageData['file'] = MTF_TESTS_PATH . $imageData['file'];
            } else {
                throw new \Exception("Image '{$imageData['file']}'' not found on the server.");
            }
        }
        $this->data = $this->fixtureData;

        return parent::getData($key);
    }
}