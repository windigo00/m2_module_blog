<?php
namespace Windigo\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action\Context,
	Magento\Framework\View\Result\PageFactory,
	Magento\Backend\App\Action
		;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    /**
     * Check the permission to run it
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Windigo_Blog::blog');
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Windigo_Blog::blog');
        $resultPage->addBreadcrumb(__('Blog'), __('Blog'));
        $resultPage->addBreadcrumb(__('Manage Blogs'), __('Manage Blogs'));
        $resultPage->getConfig()->getTitle()->prepend(__('Blogs'));

        return $resultPage;
    }
}
