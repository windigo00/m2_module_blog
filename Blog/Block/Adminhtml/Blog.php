<?php

namespace Windigo\Blog\Block\Adminhtml;

/**
 * Adminhtml blog content block
 */
class Blog extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Block constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_blog';
        $this->_blockGroup = 'Windigo_Blog';
        $this->_headerText = __('Manage Blogs');

        parent::_construct();

        if ($this->_isAllowedAction('Windigo_Blog::save')) {
            $this->buttonList->update('add', 'label', __('Add New Blog'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
