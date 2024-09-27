<?php

declare(strict_types=1);

namespace Dss\Banner\Controller\Adminhtml\Index;

use Dss\Banner\Model\BannerFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Delete extends Action
{
    /**
     * __construct
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param BannerFactory $bannerFactory
     *
     */
    public function __construct(
        Context $context,
        protected PageFactory $resultPageFactory,
        protected BannerFactory $bannerFactory
    ) {
        parent::__construct($context);
    }
    
    /**
     * Execute
     *
     * @return mixed
     */
    public function execute(): mixed
    {
        $resultRedirectFactory = $this->resultRedirectFactory->create();
        try {
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model = $this->bannerFactory->create()->load($id);
                if ($model->getId()) {
                    $model->delete();
                    $this->messageManager->addSuccessMessage(__("Record Delete Successfully."));
                } else {
                    $this->messageManager->addErrorMessage(__("Something went wrong, Please try again."));
                }
            } else {
                $this->messageManager->addErrorMessage(__("Something went wrong, Please try again."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can't delete record, Please try again."));
        }
        return $resultRedirectFactory->setPath('*/*/index');
    }
}
