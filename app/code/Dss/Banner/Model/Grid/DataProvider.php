<?php
declare(strict_types=1);

namespace Dss\Banner\Model\Grid;

use Dss\Banner\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var $loadedData
     */
    protected $loadedData;

    /**
     * @var $collection
     */
    protected $collection;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        protected StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * GetData
     *
     * @return mixed
     */
    public function getData()
    {
        if ($this->loadedData === null) {
            $items = $this->collection->getItems();
            foreach ($items as $model) {
                $data = $model->getData();

                // Add image data if available
                if ($model->getImageField()) {
                    $data['image_field'] = [
                        [
                            'name' => $model->getImageField(),
                            'url' => $this->getMediaUrl($model->getImageField()),
                        ]
                    ];
                }
                // Populate loadedData with all the data fields
                $this->loadedData[$model->getId()] = $data;
            }
        }

        return $this->loadedData;
    }
    
    /**
     * GetMediaUrl
     *
     * @param Mixed $path
     *
     * @return void
     */
    public function getMediaUrl($path = '')
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . 'wysiwyg/banner/' . $path;
        return $mediaUrl;
    }
}
