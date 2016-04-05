<?php

namespace Windigo\Blog\Controller\Index;

use Windigo\Blog\Controller\AbstractBlog,
	Windigo\Blog\Model\BlogFactory,
	Magento\Framework\View\Result\PageFactory,
	Magento\Framework\App\Action\Context
		;

/**
 * Blog Index Controller
 *
 * @author windigo
 */
class Index extends AbstractBlog {

	/**
	 * @var \Windigo\Blog\Model\BlogFactory
	 */
	protected $modelBlogFactory;

	/**
	 * @param Context $context
	 * @param BlogFactory $modelBlogFactory
	 */
	public function __construct(Context $context, PageFactory $pageFactory, BlogFactory $modelBlogFactory) {
		parent::__construct($context, $pageFactory);
		$this->modelBlogFactory = $modelBlogFactory;
	}

	public function execute()
	{
		$blogModel = $this->modelBlogFactory->create();

		// Load the item with ID is 1
		$item = $blogModel->load(1);
//		var_dump($item->getData());

		// Get blog collection
		$blogCollection = $blogModel->getCollection();
		// Load all data of collection
//		var_dump($blogCollection->getData());
		
		
		$result = $this->resultPageFactory->create();
		
		return $result;
	}
	
}
