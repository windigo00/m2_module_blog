<?php

namespace Windigo\Blog\Block\Adminhtml\Blog\Widget;

/**
 * Blog chooser for Wysiwyg widget
 *
 * @author kubik
 */
class Chooser extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Windigo\Blog\Model\Blog
     */
    protected $_blog;

    /**
     * @var \Windigo\Blog\Model\BlogFactory
     */
    protected $_blogFactory;

    /**
     * @var \Windigo\Blog\Model\Resource\Blog\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Windigo\Blog\Model\Blog $blog
     * @param \Windigo\Blog\Model\BlogFactory $blogFactory
     * @param \Windigo\Blog\Model\Resource\Blog\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Windigo\Blog\Model\Blog $blog,
        \Windigo\Blog\Model\BlogFactory $blogFactory,
        \Windigo\Blog\Model\Resource\Blog\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_blog = $blog;
        $this->_blogFactory = $blogFactory;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Block construction, prepare grid params
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        //$this->setDefaultSort('name');
        $this->setUseAjax(true);
        $this->setDefaultFilter(['chooser_is_active' => '1']);
    }

    /**
     * Prepare chooser element HTML
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element Form Element
     * @return \Magento\Framework\Data\Form\Element\AbstractElement
     */
    public function prepareElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $uniqId = $this->mathRandom->getUniqueHash($element->getId());
        $sourceUrl = $this->getUrl('wblog/blog_widget/chooser', ['uniq_id' => $uniqId]);

        $chooser = $this->getLayout()->createBlock(
            'Magento\Widget\Block\Adminhtml\Widget\Chooser'
        )->setElement(
            $element
        )->setConfig(
            $this->getConfig()
        )->setFieldsetId(
            $this->getFieldsetId()
        )->setSourceUrl(
            $sourceUrl
        )->setUniqId(
            $uniqId
        );

        if ($element->getValue()) {
            $blog = $this->_blogFactory->create()->load((int)$element->getValue());
            if ($blog->getId()) {
                $chooser->setLabel($this->escapeHtml($blog->getTitle()));
            }
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }

    /**
     * Grid Row JS Callback
     *
     * @return string
     */
    public function getRowClickCallback()
    {
        $chooserJsObject = $this->getId();
        $js = '
            function (grid, event) {
                var trElement = Event.findElement(event, "tr");
                var blogTitle = trElement.down("td").next().innerHTML;
                var blogId = trElement.down("td").innerHTML.replace(/^\s+|\s+$/g,"");
                ' .
            $chooserJsObject .
            '.setElementValue(blogId);
                ' .
            $chooserJsObject .
            '.setElementLabel(blogTitle);
                ' .
            $chooserJsObject .
            '.close();
            }
        ';
        return $js;
    }

    /**
     * Prepare blogs collection
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();
        /* @var $collection \Windigo\Blog\Model\Resource\Blog\CollectionFactory */
        $collection->setFirstStoreFlag(true);
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare columns for blogs grid
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'chooser_id',
            [
                'header' => __('ID'),
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'chooser_title',
            [
                'header' => __('Title'),
                'index' => 'title',
                'header_css_class' => 'col-title',
                'column_css_class' => 'col-title'
            ]
        );

        $this->addColumn(
            'chooser_identifier',
            [
                'header' => __('URL Key'),
                'index' => 'identifier',
                'header_css_class' => 'col-url',
                'column_css_class' => 'col-url'
            ]
        );


        $this->addColumn(
            'chooser_is_active',
            [
                'header' => __('Status'),
                'index' => 'is_active',
                'type' => 'options',
                'options' => $this->_blog->getAvailableStatuses(),
                'header_css_class' => 'col-status',
                'column_css_class' => 'col-status'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('wblog/blog_widget/chooser', ['_current' => true]);
    }
}
