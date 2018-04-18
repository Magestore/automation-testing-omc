<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/18/2017
 * Time: 4:41 PM
 */

namespace Magento\Rewardpoints\Test\Fixture\Transaction;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;


class Customer extends DataSource
{
    protected $customer;

    public function __construct(FixtureFactory $fixtureFactory, array $params, array $data = [])
    {
        $this->params = $params;
        if (isset($data['dataset'])) {
            $customer = $fixtureFactory->createByCode('customer', ['dataset' => $data['dataset']]);
            $customer->persist();
//            $this->customer = $customer;
//            $this->data =  $customer->getEmail();
            $this->data = $customer->getEmail();
            $this->customer = $customer;
        }
    }

    public function getCustomer()
    {
        return $this->customer;
    }
}