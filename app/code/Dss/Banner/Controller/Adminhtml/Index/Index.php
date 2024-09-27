<?php

declare(strict_types=1);

namespace Dss\Banner\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * __construct
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     *
     */
    public function __construct(
        Context $context,
        protected PageFactory $resultPageFactory
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
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Manage Banner Grid'));
        return $resultPage;
    }
}
