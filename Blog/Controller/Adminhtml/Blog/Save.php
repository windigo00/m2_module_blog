<?php

namespace Windigo\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     */
    public function __construct(Action\Context $context, PostDataProcessor $dataProcessor)
    {
        $this->dataProcessor = $dataProcessor;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Windigo_Blog::save');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $data = $this->dataProcessor->filter($data);
            $model = $this->_objectManager->create('Windigo\Blog\Model\Blog');

            $id = $this->getRequest()->getParam('blog_id');
            if ($id) {
                $model->load($id);
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'wblog_blog_prepare_save',
                ['blog' => $model, 'request' => $this->getRequest()]
            );

            if (!$this->dataProcessor->validate($data)) {
                return $resultRedirect->setPath('*/*/edit', ['blog_id' => $model->getId(), '_current' => true]);
            }

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved this blog.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['blog_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the blog.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['blog_id' => $this->getRequest()->getParam('blog_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
