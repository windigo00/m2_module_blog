<?php
namespace Windigo\Blog\Model;

use Windigo\Blog\Api\Data;
use Windigo\Blog\Api\BlogRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Windigo\Blog\Model\ResourceModel\Blog as ResourceBlog;
use Windigo\Blog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class BlogRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BlogRepository implements BlogRepositoryInterface
{
    /**
     * @var ResourceBlog
     */
    protected $resource;

    /**
     * @var BlogFactory
     */
    protected $blogFactory;

    /**
     * @var BlogCollectionFactory
     */
    protected $blogCollectionFactory;

    /**
     * @var Data\BlogSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Windigo\Blog\Api\Data\BlogInterfaceFactory
     */
    protected $dataBlogFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param ResourceBlog $resource
     * @param BlogFactory $blogFactory
     * @param Data\BlogInterfaceFactory $dataBlogFactory
     * @param BlogCollectionFactory $blogCollectionFactory
     * @param Data\BlogSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceBlog $resource,
        BlogFactory $blogFactory,
        Data\BlogInterfaceFactory $dataBlogFactory,
        BlogCollectionFactory $blogCollectionFactory,
        Data\BlogSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->blogFactory = $blogFactory;
        $this->blogCollectionFactory = $blogCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->datablogFactory = $datablogFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * Save Blog data
     *
     * @param \Windigo\Blog\Api\Data\BlogInterface $blog
     * @return Blog
     * @throws CouldNotSaveException
     */
    public function save(\Windigo\Blog\Api\Data\BlogInterface $blog)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $blog->setStoreId($storeId);
        try {
            $this->resource->save($blog);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $blog;
    }

    /**
     * Load Blog data by given Blog Identity
     *
     * @param string $blogId
     * @return Blog
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($blogId)
    {
        $blog = $this->blogFactory->create();
        $blog->load($blogId);
        if (!$blog->getId()) {
            throw new NoSuchEntityException(__('CMS Blog with id "%1" does not exist.', $blogId));
        }
        return $blog;
    }

    /**
     * Load Blog data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Windigo\Blog\Model\ResourceModel\Blog\Collection
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->blogCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurBlog($criteria->getCurrentBlog());
        $collection->setBlogSize($criteria->getBlogSize());
        $blogs = [];
        /** @var Blog $blogModel */
        foreach ($collection as $blogModel) {
            $blogData = $this->dataBlogFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $blogData,
                $blogModel->getData(),
                'Windigo\Blog\Api\Data\BlogInterface'
            );
            $blogs[] = $this->dataObjectProcessor->buildOutputDataArray(
                $blogData,
                'Windigo\Blog\Api\Data\BlogInterface'
            );
        }
        $searchResults->setItems($blogs);
        return $searchResults;
    }

    /**
     * Delete Blog
     *
     * @param \Windigo\Blog\Api\Data\BlogInterface $blog
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(\Windigo\Blog\Api\Data\BlogInterface $blog)
    {
        try {
            $this->resource->delete($blog);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete Blog by given Blog Identity
     *
     * @param string $blogId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($blogId)
    {
        return $this->delete($this->getById($blogId));
    }
}
