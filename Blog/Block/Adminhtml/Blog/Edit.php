<?php

namespace Windigo\Blog\Block\Adminhtml\Blog;

/**
 * Admin Blog
 *
 * @author Kubik
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize blog edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'blog_id';
        $this->_blockGroup = 'Windigo_Blog';
        $this->_controller = 'adminhtml_blog';

        parent::_construct();

        if ($this->_isAllowedAction('Windigo_Blog::save')) {
            $this->buttonList->update('save', 'label', __('Save Blog'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ]
                ],
                -100
            );
        } else {
            $this->buttonList->remove('save');
        }

        if ($this->_isAllowedAction('Windigo_Blog::blog_delete')) {
            $this->buttonList->update('delete', 'label', __('Delete Blog'));
        } else {
            $this->buttonList->remove('delete');
        }
    }

    /**
     * Retrieve text for header element depending on loaded blog
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('blog')->getId()) {
            return __("Edit Blog '%1'", $this->escapeHtml($this->_coreRegistry->registry('blog')->getTitle()));
        } else {
            return __('New Blog');
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

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('blog/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '{{tab_id}}']);
    }

    /**
     * Prepare layout
     *
     * @return \Magento\Framework\View\Element\AbstractBlock
     */
    protected function _prepareLayout()
    {
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('blog_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'blog_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'blog_content');
                }
            };
        ";
        return parent::_prepareLayout();
    }
}
