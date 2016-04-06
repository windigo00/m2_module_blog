<?php

namespace Windigo\Blog\Controller\View;

use \Magento\Framework\App\Action\Action;

class Index extends Action
{
    /** @var  \Magento\Framework\View\Result\Page */
    protected $resultPageFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
	 * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(\Magento\Framework\App\Action\Context $context,
                                \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
    )
    {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * Blog Index, shows a list of recent blog posts.
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $blog_id = $this->getRequest()->getParam('id', $this->getRequest()->getParam('id', false));
        /** @var \Windigo\Blog\Helper\Blog $blog_helper */
        $blog_helper = $this->_objectManager->get('\Windigo\Blog\Helper\Blog');
        $result_page = $blog_helper->prepareResultBlog($this, $blog_id);
        if (!$result_page) {
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }
        return $result_page;
    }
}