<?php

declare(strict_types=1);

namespace Dss\Banner\Block;

use Dss\Banner\Model\Banner;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Index extends Template
{
    
    /**
     * __construct
     *
     * @param Context $context
     * @param Banner $customCollection
     * @param array $data
     *
     * @return void
     */
    public function __construct(
        protected Context $context,
        protected Banner $customCollection,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
    
    /**
     * GetPagerHtml
     *
     * @return void
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
    /**
     * GetBannerCollection
     *
     * @return void
     */
    public function getBannerCollection()
    {
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest(
        )->getParam('limit') : 8;
        $collection = $this->customCollection->getCollection();
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }
}
