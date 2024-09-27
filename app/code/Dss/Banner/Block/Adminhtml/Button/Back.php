<?php

declare(strict_types=1);

namespace Dss\Banner\Block\Adminhtml\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Back extends Generic implements ButtonProviderInterface
{
    /**
     * GetButtonData
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10,
        ];
    }
    
    /**
     * GetBackUrl
     *
     * @return mixed
     */
    public function getBackUrl(): mixed
    {
        return $this->getUrl('*/*/');
    }
}
