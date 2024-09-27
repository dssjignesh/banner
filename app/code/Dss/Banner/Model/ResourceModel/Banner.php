<?php

declare(strict_types=1);

namespace Dss\Banner\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Banner extends AbstractDb
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';
    
    /**
     * _construct
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('dss_banner', 'id');
    }
}
