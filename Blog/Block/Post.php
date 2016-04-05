<?php

namespace Windigo\Blog\Block;

use Magento\Framework\View\Element\Template,
	Magento\Framework\DataObject\IdentityInterface,
	Windigo\Blog\Api\Data\BlogInterface,
	Windigo\Blog\Model\Resource\Post\Collection as PostCollection,
	Windigo\Blog\Model\Blog as BlogModel,
	Windigo\Blog\Model\Post as PostModel;

/**
 * Description of Post
 *
 * @author KuBik
 */
class Post extends Template implements IdentityInterface {
	/**
     * @var \Windigo\Blog\Model\Resource\Post\CollectionFactory
     */
    protected $postCollectionFactory;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Windigo\Blog\Model\Resource\Post\CollectionFactory $postCollectionFactory,
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Windigo\Blog\Model\Resource\Post\CollectionFactory $postCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->postCollectionFactory = $postCollectionFactory;
    }
	
	/**
     * Return identifiers for produced content
     *
     * @return array
     */
	public function getIdentities() {
		return [PostModel::CACHE_TAG . '_' . 'list' ];
	}
}
