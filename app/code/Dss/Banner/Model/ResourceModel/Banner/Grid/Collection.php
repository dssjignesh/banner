<?php

declare(strict_types=1);

namespace Dss\Banner\Model\ResourceModel\Banner\Grid;

use Dss\Banner\Model\ResourceModel\Banner\Collection as BannerCollection;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document as BannerModel;
use Psr\Log\LoggerInterface;

class Collection extends BannerCollection implements \Magento\Framework\Api\Search\SearchResultInterface
{
    /**
     * collection constructor.
     *
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param mixed $mainTable
     * @param mixed $eventPrefix
     * @param mixed $eventObject
     * @param mixed $resourceModel
     * @param mixed $model
     * @param mixed $connection
     * @param AbstractDb|null $resource
     */
    public function __construct(
        protected EntityFactoryInterface $entityFactory,
        protected LoggerInterface $logger,
        protected FetchStrategyInterface $fetchStrategy,
        protected ManagerInterface $eventManager,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = BannerModel::class,
        $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }

    /**
     * @var mixed aggregations
     */
    protected $aggregations;
    /**
     * GetAggregations
     *
     * @return Mixed
     */

    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * SetAggregations
     *
     * @param Mixed $aggregations
     *
     * @return void
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    /**
     * GetAllIds
     *
     * @param Mixed $limit
     * @param mixed $offset
     *
     * @return mixed
     */
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }

    /**
     * GetSearchCriteria
     *
     * @return null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * SetSearchCriteria
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return $this
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * GetTotalCount
     *
     * @return mixed
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * SetTotalCount
     *
     * @param Mixed $totalCount
     *
     * @return static
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }
    
    /**
     * SetItems
     *
     * @param Array $items
     *
     * @return static
     */
    public function setItems(array $items = null)
    {
        return $this;
    }
}
