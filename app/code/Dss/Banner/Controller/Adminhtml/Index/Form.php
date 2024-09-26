<?php

declare(strict_types=1);

namespace Dss\Banner\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;

class Form extends Action
{
    
    /**
     * __construct
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     *
     * @return void
     */
    public function __construct(
        protected Context $context,
        protected PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
    }
    /**
     * Execute
     *
     * @return void
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Form'));
        return $resultPage;
    }
}
