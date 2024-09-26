<?php
declare(strict_types=1);

namespace Dss\Banner\Model\ResourceModel\Banner\Grid;

use Dss\Banner\Model\ResourceModel\Banner\Collection as BannerCollection;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document as BannerModel;

class Collection extends BannerCollection implements \Magento\Framework\Api\Search\SearchResultInterface
{
    /**
     * @var mixed aggregations
     */
    protected $aggregations;

    // @codingStandardsIgnoreStart
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = BannerModel::class,
        $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }
    // @codingStandardsIgnoreEnd
    
    /**
     * GetAggregations
     *
     * @return void
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
     * @return void
     */
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }
    /**
     * GetSearchCriteria
     *
     * @return void
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
     * @return void
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }
    /**
     * GetTotalCount
     *
     * @return void
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
     * @return void
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
     * @return void
     */
    public function setItems(array $items = null)
    {
        return $this;
    }
}
