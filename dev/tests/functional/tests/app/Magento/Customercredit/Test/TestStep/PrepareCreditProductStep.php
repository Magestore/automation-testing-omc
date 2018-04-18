<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/6/2017
 * Time: 1:44 PM
 */

namespace Magento\Customercredit\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Mtf\Fixture\FixtureFactory;

class PrepareCreditProductStep implements TestStepInterface
{
    protected $fixtureFactory;
    public function __construct(FixtureFactory $fixtureFactory)
    {
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * Run step flow
     *
     * @return mixed
     */
    public function run()
    {
        $credit = $this->fixtureFactory->createByCode('creditProduct', ['dataset' => 'default1']);
        $credit->persist();
    }
}