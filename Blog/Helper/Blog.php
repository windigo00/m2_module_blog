<?php
namespace Windigo\Blog\Helper;

use Magento\Framework\App\Action\Action,
	Magento\Framework\App\Helper\AbstractHelper;
/**
 * Description of Blog helper
 *
 * @author KuBik
 */
class Blog extends AbstractHelper {
	/**
     * @var \Windigo\Blog\Model\Blog
     */
    protected $_blog;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Windigo\Blog\Model\Blog $blog
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Windigo\Blog\Model\Blog $blog,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        $this->_blog = $blog;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Return a blog blog from given blog id.
     *
     * @param Action $action
     * @param null $blogId
     * @return \Magento\Framework\View\Result\Page|bool
     */
    public function prepareResultBlog(Action $action, $blogId = null)
    {
        if ($blogId !== null && $blogId !== $this->_blog->getId()) {
            $delimiterPosition = strrpos($blogId, '|');
            if ($delimiterPosition) {
                $blogId = substr($blogId, 0, $delimiterPosition);
            }

            if (!$this->_blog->load($blogId)) {
                return false;
            }
        }

        if (!$this->_blog->getId()) {
            return false;
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        // We can add our own custom page handles for layout easily.
        $resultPage->addHandle('blog_view');

        // This will generate a layout handle like: blog_blog_view_id_1
        // giving us a unique handle to target specific blog blogs if we wish to.
        $resultPage->addPageLayoutHandles(['id' => $this->_blog->getId()]);

        // Magento is event driven after all, lets remember to dispatch our own, to help people
        // who might want to add additional functionality, or filter the blogs somehow!
        $this->_eventManager->dispatch(
            'windigo_blog_render',
            ['blog' => $this->_blog, 'controller_action' => $action]
        );

        return $resultPage;
    }
}
