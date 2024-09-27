<?php

declare(strict_types=1);

namespace Dss\Banner\Model;

use Dss\Banner\Model\ResourceModel\Banner as BannerResourceModel;
use Magento\Framework\Model\AbstractModel;

class Banner extends AbstractModel
{
    /**
     * _construct
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(BannerResourceModel::class);
    }
}
