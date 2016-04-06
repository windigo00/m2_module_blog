<?php

namespace Windigo\Blog\Block\Adminhtml\Blog\Edit;

/**
 * Admin blog left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('blog_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Blog Information'));
    }
}
