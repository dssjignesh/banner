<?php

declare(strict_types=1);

namespace Dss\Banner\Controller\Adminhtml\Index;

use Dss\Banner\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * __construct
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     *
     */
    public function __construct(
        Context $context,
        protected Filter $filter,
        protected CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $recordDeleted = 0;
        foreach ($collection as $record) {
            try {
                $record->delete();
                $recordDeleted++;
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Error deleting record ID %1', $record->getId()));
            }
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $recordDeleted));
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }
}