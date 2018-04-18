<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/11/2017
 * Time: 8:08 AM
 */

namespace Magento\Storepickup\Test\Block\Adminhtml\Store\Edit\Tab;

use Magento\Backend\Test\Block\Widget\Tab;
use Magento\Mtf\Client\Element\SimpleElement;
use Magento\Mtf\Client\Locator;

class ImageGallery extends Tab
{
    /**
     * Selector for image loader container.
     *
     * @var string
     */
    private $imageLoader = '.image-loader-wrapper';

    /**
     * Selector for first uploaded image.
     *
     * @var string
     */
    private $baseImage = '.image.image-item.element-image';

    /**
     * Selector for image upload input.
     *
     * @var string
     */
    private $imageUploadInput = '[name="image"]';

    /**
     * Upload product images.
     *
     * @param array $data
     * @param SimpleElement|null $element
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setFieldsData(array $data, SimpleElement $element = null)
    {
        foreach ($data['baseimage_id']['value'] as $imageData) {
            $uploadElement = $element->find($this->imageUploadInput, Locator::SELECTOR_CSS, 'upload');
            $uploadElement->setValue($imageData['file']);
            $this->waitForElementNotVisible($this->imageLoader);
            $this->waitForElementVisible($this->baseImage);
        }
        return $this;
    }
}