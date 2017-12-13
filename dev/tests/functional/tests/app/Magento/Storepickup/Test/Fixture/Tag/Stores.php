<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/6/2017
 * Time: 4:01 PM
 */

namespace Magento\Storepickup\Test\Fixture\Tag;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;

class Stores extends DataSource
{
    protected $stores = [];

    public function __construct(
        FixtureFactory $fixtureFactory,
        array $params,
        array $data = []
    ) {
        $this->params = $params;
        if (isset($data['dataset']) && $data['dataset'] !== '-') {
            $datasets = explode(',', $data['dataset']);
            foreach ($datasets as $dataset) {
                $store = $fixtureFactory->createByCode('storepickupStore', ['dataset' => trim($dataset)]);
                if (!$store->hasData('storepickup_id')) {
                    $store->persist();
                }
                $this->stores[] = $store;
                $this->data[] = [
                    'id' => $store->getStorepickupId(),
                    'name' => $store->getStoreName()
                ];
            }
        }
    }

    /**
     * Return related products.
     *
     * @return array
     */
    public function getStores()
    {
        return $this->stores;
    }
}