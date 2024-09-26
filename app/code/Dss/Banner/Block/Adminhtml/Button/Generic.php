<?php

declare(strict_types=1);

namespace Dss\Banner\Block\Adminhtml\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Cms\Api\PageRepositoryInterface;

class Generic
{
        
    /**
     * __construct
     *
     * @param Context $context
     * @param PageRepositoryInterface $pageRepository
     *
     * @return void
     */
    public function __construct(
        protected Context $context,
        protected PageRepositoryInterface $pageRepository
    ) {
    }
    
    /**
     * GetUrl
     *
     * @param Mixed $route
     * @param Mixed $params
     *
     * @return void
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
