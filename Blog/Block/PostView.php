<?php
namespace Windigo\Blog\Block;

use Magento\Framework\View\Element\Template,
	Magento\Framework\DataObject\IdentityInterface,
	Magento\Framework\View\Element\Template\Context,
	Windigo\Blog\Model\Post as PostModel,
	Windigo\Blog\Model\PostFactory
		;

class PostView extends Template implements IdentityInterface {

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Windigo\Blog\Model\Post $post
     * @param \Windigo\Blog\Model\PostFactory $postFactory
     * @param array $data
     */
    public function __construct(Context $context, PostModel $post, PostFactory $postFactory, array $data = []) {
        parent::__construct($context, $data);
        $this->_post = $post;
        $this->_postFactory = $postFactory;
    }

    /**
     * @return \Windigo\Blog\Model\Post
     */
    public function getPost()
    {
        // Check if posts has already been defined
        // makes our block nice and re-usable! We could
        // pass the 'posts' data to this block, with a collection
        // that has been filtered differently!
        if (!$this->hasData('post')) {
            if ($this->getPostId()) {
                /** @var \Windigo\Blog\Model\Post $post */
                $post = $this->_postFactory->create();
            } else {
                $post = $this->_post;
            }
            $this->setData('post', $post);
        }
        return $this->getData('post');
    }

    /**
     * Return identifiers for produced content
     *
     * @return array
     */
    public function getIdentities()
    {
        return [\Windigo\Blog\Model\Post::CACHE_TAG . '_' . $this->getPost()->getId()];
    }

}