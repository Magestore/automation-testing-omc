<?php
namespace Magento\Giftvoucher\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Customer\Test\Page\CustomerAccountIndex;
use Magento\Giftvoucher\Test\Page\GiftvoucherIndexIndex;

class OpenGiftCardFromMyAccountStep implements TestStepInterface
{
    /**
     * Account Dashboard Page
     * 
     * @var CustomerAccountIndex
     */
    protected $customerAccountIndex;
    
    /**
     * Gift Card Index Page
     * 
     * @var GiftvoucherIndexIndex
     */
    protected $giftvoucherIndexIndex;
    
    public function __construct(
        CustomerAccountIndex $customerAccountIndex,
        GiftvoucherIndexIndex $giftvoucherIndexIndex
    ) {
        $this->customerAccountIndex = $customerAccountIndex;
        $this->giftvoucherIndexIndex = $giftvoucherIndexIndex;
    }
    
    public function run()
    {
        $this->customerAccountIndex->getAccountMenuBlock()->openMenuItem('Gift Card');
        $this->giftvoucherIndexIndex->getAccountGiftcodesBlock()->waitPageInit();
    }
}
