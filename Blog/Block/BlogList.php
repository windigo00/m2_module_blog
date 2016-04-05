<?php
namespace Windigo\Blog\Block;

use Magento\Framework\View\Element\Template,
	Magento\Framework\DataObject\IdentityInterface,
	Windigo\Blog\Api\Data\BlogInterface,
	Windigo\Blog\Model\Resource\Blog\Collection as BlogCollection,
	Windigo\Blog\Model\Blog as BlogModel;

/**
 * Description of Blog
 *
 * @author KuBik
 */
class BlogList extends Template implements IdentityInterface {
	
	/**
     * @var \Windigo\Blog\Model\Resource\Blog\CollectionFactory
     */
    protected $blogCollectionFactory;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Windigo\Blog\Model\Resource\Blog\CollectionFactory $blogCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Windigo\Blog\Model\Resource\Blog\CollectionFactory $blogCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->blogCollectionFactory = $blogCollectionFactory;
    }

    /**
     * @return \Windigo\Blog\Model\Resource\Blog\Collection
     */
    public function getBlogs()
    {
        if (!$this->hasData('blogs')) {
            $blogs = $this->blogCollectionFactory
                ->create()
                ->addFilter('is_active', 1)
                ->addOrder(
                    BlogInterface::CREATION_TIME,
                    BlogCollection::SORT_ORDER_DESC
                );
            $this->setData('blogs', $blogs);
        }
        return $this->getData('blogs');
    }
	
	/**
     * Return identifiers for produced content
     *
     * @return array
     */
	public function getIdentities() {
		return [BlogModel::CACHE_TAG . '_' . 'list'];
	}
}
