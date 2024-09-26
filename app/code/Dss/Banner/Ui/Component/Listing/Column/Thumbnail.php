<?php

declare(strict_types=1);

namespace Dss\Banner\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Helper\Image;

class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * Magento\Framework\UrlInterface $urlBuilder
     * @param StoreManagerInterface $storeManager
     * @param Image $imageHelper
     * @param Array $components
     * @param Array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        protected StoreManagerInterface $storeManager,
        protected Image $imageHelper,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            $path = $this->storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            );
            foreach ($dataSource['data']['items'] as & $item) {
                $url = '';
                if (isset($item[$fieldName])) {
                    if ($item[$fieldName] != '') {
                        $url = $this->storeManager->getStore()->getBaseUrl(
                            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                        ) . "wysiwyg/banner/" . $item[$fieldName];
                    } else {
                        $url = $this->imageHelper->getDefaultPlaceholderUrl('small_image');
                    }
                } else {
                    $url = $this->imageHelper->getDefaultPlaceholderUrl('small_image');
                }
                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_alt'] = $item['title'];
                $item[$fieldName . '_orig_src'] = $url;
            }
        }

        return $dataSource;
    }
}
