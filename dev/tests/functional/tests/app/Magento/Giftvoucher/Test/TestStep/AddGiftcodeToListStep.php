<?php
namespace Magento\Giftvoucher\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Giftvoucher\Test\Page\GiftvoucherIndexIndex;
use Magento\Giftvoucher\Test\Page\GiftvoucherIndexAdd;
use Magento\Giftvoucher\Test\Fixture\Giftcode;

class AddGiftcodeToListStep implements TestStepInterface
{
    /**
     * Gift Card Index Page
     *
     * @var GiftvoucherIndexIndex
     */
    protected $giftvoucherIndexIndex;

    /**
     * Gift Card Add Page
     *
     * @var GiftvoucherIndexAdd
     */
    protected $giftvoucherIndexAdd;

    /**
     * @var Giftcode
     */
    protected $giftcode;

    public function __construct(
        GiftvoucherIndexIndex $giftvoucherIndexIndex,
        GiftvoucherIndexAdd $giftvoucherIndexAdd,
        Giftcode $giftcode,
        $code = null
    ) {
        $this->giftvoucherIndexIndex = $giftvoucherIndexIndex;
        $this->giftvoucherIndexAdd = $giftvoucherIndexAdd;
        if (!$code) {
            $giftcode->persist();
        }
        $this->giftcode = $giftcode;
    }

    public function run()
    {
        $this->giftvoucherIndexIndex->getAccountGiftcodesBlock()->add();
        $this->giftvoucherIndexAdd->getAddGiftcodeForm()->waitPageInit();
        $this->giftvoucherIndexAdd->getAddGiftcodeForm()->addGiftcode($this->giftcode->getGiftCode());
        return ['giftcode' => $this->giftcode, 'code' => $this->giftcode->getGiftCode()];
    }
}
