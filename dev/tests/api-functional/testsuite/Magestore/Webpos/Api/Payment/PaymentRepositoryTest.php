<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/12/2017
 * Time: 08:30
 */

namespace Magestore\Webpos\Api\Payment;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class PaymentRepositoryTest
 * @package Magestore\Webpos\Api\Payment
 */
class PaymentRepositoryTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/webpos/payments';

    /**
     * @var \Magestore\Webpos\Api\Payment\Constraint\PaymentRepository
     */
    protected $paymentRepository;

    protected function setUp()
    {
        $this->paymentRepository = Bootstrap::getObjectManager()->get('\Magestore\Webpos\Api\Payment\Constraint\PaymentRepository');
    }

    /**
     * API: Get Payment to Take payment
     */
    public function testGetList()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH .'?' ,
                'httpMethod' => RestRequest::HTTP_METHOD_GET,
            ]
        ];

        $results = $this->_webApiCall($serviceInfo);

        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);

        $this->assertNotNull($results);
        self::assertGreaterThanOrEqual(
            1,
            $results['total_count'],
            "The result doesn't have any item (total_count < 1)"
        );
        // Get the key constraint for API Get Payment to Take payment. Call From Folder Constraint
        $keys = $this->paymentRepository->GetList();

        foreach ($keys['items'][0] as $key) {
            self::assertContains(
                $key,
                array_keys($results['items'][0]),
                $key . " key is not in found in results['items'][0]'s keys"
            );
        }
    }
}