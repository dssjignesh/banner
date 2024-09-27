<?php

declare(strict_types=1);

namespace Dss\Banner\Block\Adminhtml\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Delete extends Generic implements ButtonProviderInterface
{
    
    /**
     * __construct
     *
     * @param Context $context
     *
     */
    public function __construct(
        protected Context $context
    ) {
    }
    
    /**
     * GetButtonData
     *
     * @return array
     */
    public function getButtonData(): array
    {
        $data = [];
        $id = $this->context->getRequest()->getParam('id');
        if ($id) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to delete this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }
    
    /**
     * GetDeleteUrl
     *
     * @return mixed
     */
    public function getDeleteUrl(): mixed
    {
        $id = $this->context->getRequest()->getParam('id');
        return $this->getUrl('*/*/delete', ['id' => $id]);
    }
}
