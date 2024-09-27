<?php

declare(strict_types=1);

namespace Dss\Banner\Model\ResourceModel\Banner;

use Dss\Banner\Model\Banner as BannerModel;
use Dss\Banner\Model\ResourceModel\Banner as BannerResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * _construct
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(
            BannerModel::class,
            BannerResourceModel::class
        );
    }
}
