<?php

declare(strict_types=1);

namespace Dss\Banner\Controller\Adminhtml\Index;

use Dss\Banner\Model\ImageUploader;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;

class Upload extends \Magento\Backend\App\Action
{
    /**
     * Upload constructor.
     * @param Context $context
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        public ImageUploader $imageUploader
    ) {
        parent::__construct($context);
    }

    /**
     * IsAllowed
     *
     * @return mixed
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dss_Banner::upload');
    }

    /**
     * Execute
     *
     * @return mixed
     */
    public function execute()
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('image_field');
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
