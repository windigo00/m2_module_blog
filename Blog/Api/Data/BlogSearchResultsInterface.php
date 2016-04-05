<?php
namespace Windigo\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for blog search results.
 * @api
 */
interface BlogSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get blogs list.
     *
     * @return \Windigo\Blog\Api\Data\BlogInterface[]
     */
    public function getItems();

    /**
     * Set blogs list.
     *
     * @param \Windigo\Blog\Api\Data\BlogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
