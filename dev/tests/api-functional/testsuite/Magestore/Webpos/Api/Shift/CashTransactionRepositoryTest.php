<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/12/2017
 * Time: 07:50
 */

namespace Magestore\Webpos\Api\Shift;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class CashTransactionRepositoryTest
 * @package Magestore\Webpos\Api\Shift
 */
class CashTransactionRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/cash_transaction/';

    /**
     * @var \Magestore\Webpos\Api\Shift\ShiftRepositoryTest
     */
    protected $openSession;

    /**
     * @var \Magestore\Webpos\Api\Shift\Constraint\CashTransactionRepository
     */
    protected $cashTransactionRepository;

    protected function setUp()
    {
        $this->openSession = Bootstrap::getObjectManager()->get('\Magestore\Webpos\Api\Shift\ShiftRepositoryTest');
        $this->cashTransactionRepository = Bootstrap::getObjectManager()->get('\Magestore\Webpos\Api\Shift\Constraint\CashTransactionRepository');
    }
    /**
     * Need a API web to create a new shift to get the valid shift_id
     * Make Adjustment Session
     */
    public function testSave()
    {
        $session = $this->openSession->openSession();
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . 'save?',
                'httpMethod' => RestRequest::HTTP_METHOD_POST,
            ]
        ];

        $requestData = [
            'cashTransaction' => [
                'shift_id' => $session[0]['shift_id'],
                'transaction_currency_code' => 'USD',
                'note' => '',
                'base_value' => 50,
                'created_at' => '2017-12-18 07:59:00',
                'location_id' => 1,
                'value' => 50,
                'type' => 'add',
                'base_currency_code' => 'USD',
            ]
        ];

        $results = $this->_webApiCall($serviceInfo, $requestData);

        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);

        $this->assertNotNull($results);
        // Get the key constraint for API Make Adjustment Session. Call From Folder Constraint
        $keys = $this->cashTransactionRepository->Save();

        foreach ($keys as $key) {
            self::assertContains(
                $key,
                array_keys($results),
                $key . " key is not in found in results's keys"
            );
        }
    }
}