<?php

declare(strict_types=1);

namespace Dss\Banner\Block\Adminhtml\Button;

class Reset extends \Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic
{
    /**
     * GetButtonData
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30,
        ];
    }
}
