<?php

declare(strict_types=1);

namespace Dss\Banner\Block\Adminhtml\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Back extends Generic implements ButtonProviderInterface
{
    /**
     * GetButtonData
     *
     * @return void
     */
    public function getButtonData()
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
     * @return void
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/');
    }
}
