<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 02/03/2018
 * Time: 14:08
 */
namespace Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\Fixture\DataSource;

class LocationId extends DataSource
{
    /**
     * @var Location
     */
    protected $location;

    public function __construct(FixtureFactory $fixtureFactory, array $params, $data = [])
    {
        $this->params = $params;
        if (isset($data['dataset'])) {
            $location = $fixtureFactory->createByCode('location', ['dataset' => $data['dataset']]);
            $location->persist();
            $this->data = $location->getLocationId();
            $this->location = $location;
        } else {
            $this->data = $data[0];
        }
    }

    /**
     * Return location.
     *
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }
}
