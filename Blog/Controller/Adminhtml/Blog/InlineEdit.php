<?php
namespace Windigo\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action\Context,
	Windigo\Blog\Api\BlogRepositoryInterface as BlogRepository,
	Magento\Framework\Controller\Result\JsonFactory,
	Windigo\Blog\Api\Data\BlogInterface;

/**
 * Blog grid inline edit controller
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InlineEdit extends \Magento\Backend\App\Action
{
    /** @var PostDataProcessor */
    protected $dataProcessor;

    /** @var BlogRepository  */
    protected $blogRepository;

    /** @var JsonFactory  */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param PostDataProcessor $dataProcessor
     * @param BlogRepository $blogRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        PostDataProcessor $dataProcessor,
        BlogRepository $blogRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->dataProcessor = $dataProcessor;
        $this->blogRepository = $blogRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $blogId) {
            /** @var \Windigo\Blog\Model\Blog $blog */
            $blog = $this->blogRepository->getById($blogId);
            try {
                $blogData = $this->filterPost($postItems[$blogId]);
                $this->validatePost($blogData, $blog, $error, $messages);
                $extendedBlogData = $blog->getData();
                $this->setBlogData($blog, $extendedBlogData, $blogData);
                $this->blogRepository->save($blog);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithBlogId($blog, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithBlogId($blog, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithBlogId(
                    $blog,
                    __('Something went wrong while saving the blog.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Filtering posted data.
     *
     * @param array $postData
     * @return array
     */
    protected function filterPost($postData = [])
    {
        $blogData = $this->dataProcessor->filter($postData);
        $blogData['custom_theme'] = /*isset($blogData['custom_theme']) ? $blogData['custom_theme'] : */null;
        $blogData['custom_root_template'] = /*isset($blogData['custom_root_template'])
            ? $blogData['custom_root_template']
            : */null;
        return $blogData;
    }

    /**
     * Validate post data
     *
     * @param array $blogData
     * @param \Windigo\Blog\Model\Blog $blog
     * @param bool $error
     * @param array $messages
     * @return void
     */
    protected function validatePost(array $blogData, \Windigo\Blog\Model\Blog $blog, &$error, array &$messages)
    {
        if (!($this->dataProcessor->validate($blogData) && $this->dataProcessor->validateRequireEntry($blogData))) {
            $error = true;
            foreach ($this->messageManager->getMessages(true)->getItems() as $error) {
                $messages[] = $this->getErrorWithBlogId($blog, $error->getText());
            }
        }
    }

    /**
     * Add blog title to error message
     *
     * @param BlogInterface $blog
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithBlogId(BlogInterface $blog, $errorText)
    {
        return '[Blog ID: ' . $blog->getId() . '] ' . $errorText;
    }

    /**
     * Set blog data
     *
     * @param \Windigo\Blog\Model\Blog $blog
     * @param array $extendedBlogData
     * @param array $blogData
     * @return $this
     */
    public function setBlogData(\Windigo\Blog\Model\Blog $blog, array $extendedBlogData, array $blogData)
    {
        $blog->setData(array_merge($blog->getData(), $extendedBlogData, $blogData));
        return $this;
    }
}
