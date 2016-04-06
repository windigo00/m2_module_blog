<?php
namespace Windigo\Blog\Controller;

use Magento\Framework\App\Action\Action,
	Magento\Framework\App\Action\Context,
	Magento\Framework\View\Result\PageFactory
		;

/**
 * Description of AbstractBlog
 *
 * @author KuBik
 */
class AbstractBlog extends Action{
	/**
	 *
	 * @var \Magento\Framework\View\Result\PageFactory
	 */
	protected $resultPageFactory;


	/**
	 * @param Context $context
	 * @param PageFactory $pageFactory
	 */
	public function __construct(Context $context, PageFactory $pageFactory) {
		parent::__construct($context);
		$this->resultPageFactory = $pageFactory;
	}
	
	/**
	 * Executes default index action
	 */
	public function execute() {
		$result = $this->resultPageFactory->create();
		return $result;
	}
}
