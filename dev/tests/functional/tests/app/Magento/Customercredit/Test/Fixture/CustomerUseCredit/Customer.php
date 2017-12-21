<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/21/2017
 * Time: 9:26 AM
 */

namespace Magento\Customercredit\Test\Fixture\CustomerUseCredit;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;

class Customer extends DataSource
{
    /**
     * Customer fixture
     *
     */
    protected $customerFixture;

    /**
     * @constructor
     * @param FixtureFactory $fixtureFactory
     * @param array $params
     * @param array $data
     */
    public function __construct(FixtureFactory $fixtureFactory, array $params, array $data = [])
    {
        $this->params = $params;

        if (isset($data['dataset'])) {
            /** @var \Magento\Customer\Test\Fixture\Customer $customer*/
            $customer = $fixtureFactory->createByCode('customer', ['dataset' => $data['dataset']]);
            $customer->persist();
            $this->data = $customer->getData();
            $this->data['entity_id'] = $customer->getId();
            $this->data['group_id'] = '1';
            $this->data['website_id'] = '1';
            $this->customerFixture = $customer;

        }
    }

    /**
     * Getting customer fixture.
     *
     * @return array
     */
    public function getCustomer()
    {
        return $this->customerFixture;
    }
}