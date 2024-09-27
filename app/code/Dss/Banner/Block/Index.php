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
     */
    public function __construct(
        Context $context,
        protected Banner $customCollection,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
    
    /**
     * GetPagerHtml
     *
     * @return mixed
     */
    public function getPagerHtml(): mixed
    {
        return $this->getChildHtml('pager');
    }

    /**
     * GetBannerCollection
     *
     * @return mixed
     */
    public function getBannerCollection(): mixed
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
