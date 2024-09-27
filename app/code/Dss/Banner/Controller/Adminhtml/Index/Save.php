<?php

declare(strict_types=1);

namespace Dss\Banner\Controller\Adminhtml\Index;

use Dss\Banner\Model\BannerFactory;
use Dss\Banner\Model\ImageUploader;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Cache\Manager;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Banner Save
 * Dss\Banner\Controller\Adminhtml\Index
 */
class Save extends \Magento\Backend\App\Action
{

    /**
     * @var ManagerInterface
     */
    protected $_messageManager;
    
    /**
     * Save constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param BannerFactory $bannerFactory
     * @param ImageUploader $imageUploaderModel
     * @param ManagerInterface $messageManager
     * @param Manager $cacheManager
     */
    public function __construct(
        Context $context,
        protected PageFactory $resultPageFactory,
        protected BannerFactory $bannerFactory,
        protected ImageUploader $imageUploaderModel,
        ManagerInterface $messageManager,
        protected Manager $cacheManager
    ) {
        parent::__construct($context);
    }
    
    /**
     * Execute
     *
     * @return mixed
     */
    public function execute()
    {
        try {
            $resultPageFactory = $this->resultRedirectFactory->create();
            $data = $this->getRequest()->getPostValue();
            $model = $this->bannerFactory->create();
            $model->setData($data);
            $model = $this->imageData($model, $data);
            $model->save();
            $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
            $buttonData = $this->getRequest()->getParam('back');
        } catch (\Exception $e) {
            $this->_messageManager->addErrorMessage(__($e));
        }
        return $resultPageFactory->setPath('banner/index/index');
    }

    /**
     * ImageData
     *
     * @param \Dss\Banner\Model\Banner $model
     * @param array $data
     *
     * @return mixed
     */
    public function imageData($model, $data): mixed
    {
        if ($model->getId()) {
            $pageData = $this->bannerFactory->create();
            $pageData->load($model->getId());
            if (isset($data['image_field'][0]['name'])) {
                $imageName1 = $pageData->getThumbnail();
                $imageName2 = $data['image_field'][0]['name'];
                if ($imageName1 != $imageName2) {
                    $imageUrl = $data['image_field'][0]['url'];
                    $imageName = $data['image_field'][0]['name'];
                    $data['image_field'] = $this->imageUploaderModel->saveMediaImage($imageName, $imageUrl);
                } else {
                    $data['image_field'] = $data['image_field'][0]['name'];
                }
            } else {
                $data['image_field'] = '';
            }
        } else {
            if (isset($data['image_field'][0]['name'])) {
                $imageUrl = $data['image_field'][0]['url'];
                $imageName = $data['image_field'][0]['name'];
                $data['image_field'] = $this->imageUploaderModel->saveMediaImage($imageName, $imageUrl);
            }
        }
        $model->setData($data);
        return $model;
    }
}
