<?php
namespace Windigo\Blog\Model;

use Windigo\Blog\Api\Data\BlogInterface;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Blog Model
 *
 * @method \Windigo\Blog\Model\ResourceModel\Blog _getResource()
 * @method \Windigo\Blog\Model\ResourceModel\Blog getResource()
 */
class Blog extends \Magento\Framework\Model\AbstractModel implements BlogInterface, IdentityInterface
{
    /**#@+
     * Blog's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/

    /**
     * Blog cache tag
     */
    const CACHE_TAG = 'blog';

    /**
     * @var string
     */
    protected $_cacheTag = 'blog';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'blog';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Windigo\Blog\Model\ResourceModel\Blog');
    }

    /**
     * Load object data
     *
     * @param int|null $id
     * @param string $field
     * @return $this
     */
    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRouteBlog();
        }
        return parent::load($id, $field);
    }

    /**
     * Load No-Route Blog
     *
     * @return \Windigo\Blog\Model\Blog
     */
    public function noRouteBlog()
    {
        return $this->load(self::NOROUTE_PAGE_ID, $this->getIdFieldName());
    }

    /**
     * Receive page store ids
     *
     * @return int[]
     */
    public function getStores()
    {
        return $this->hasData('stores') ? $this->getData('stores') : $this->getData('store_id');
    }

    /**
     * Check if page identifier exist for specific store
     * return page id if page exists
     *
     * @param string $identifier
     * @param int $storeId
     * @return int
     */
    public function checkIdentifier($identifier, $storeId)
    {
        return $this->_getResource()->checkIdentifier($identifier, $storeId);
    }

    /**
     * Prepare page's statuses.
     * Available event cms_page_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return parent::getData(self::PAGE_ID);
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->getData(self::IDENTIFIER);
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Get page layout
     *
     * @return string
     */
    public function getBlogLayout()
    {
        return $this->getData(self::PAGE_LAYOUT);
    }

    /**
     * Get meta keywords
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->getData(self::META_KEYWORDS);
    }

    /**
     * Get meta description
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->getData(self::META_DESCRIPTION);
    }

    /**
     * Get content heading
     *
     * @return string
     */
    public function getContentHeading()
    {
        return $this->getData(self::CONTENT_HEADING);
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Get creation time
     *
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Get update time
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Get sort order
     *
     * @return string
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * Get layout update xml
     *
     * @return string
     */
    public function getLayoutUpdateXml()
    {
        return $this->getData(self::LAYOUT_UPDATE_XML);
    }

    /**
     * Get custom theme
     *
     * @return string
     */
    public function getCustomTheme()
    {
        return $this->getData(self::CUSTOM_THEME);
    }

    /**
     * Get custom root template
     *
     * @return string
     */
    public function getCustomRootTemplate()
    {
        return $this->getData(self::CUSTOM_ROOT_TEMPLATE);
    }

    /**
     * Get custom layout update xml
     *
     * @return string
     */
    public function getCustomLayoutUpdateXml()
    {
        return $this->getData(self::CUSTOM_LAYOUT_UPDATE_XML);
    }

    /**
     * Get custom theme from
     *
     * @return string
     */
    public function getCustomThemeFrom()
    {
        return $this->getData(self::CUSTOM_THEME_FROM);
    }

    /**
     * Get custom theme to
     *
     * @return string
     */
    public function getCustomThemeTo()
    {
        return $this->getData(self::CUSTOM_THEME_TO);
    }

    /**
     * Is active
     *
     * @return bool
     */
    public function isActive()
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setId($id)
    {
        return $this->setData(self::PAGE_ID, $id);
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setIdentifier($identifier)
    {
        return $this->setData(self::IDENTIFIER, $identifier);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set page layout
     *
     * @param string $pageLayout
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setBlogLayout($pageLayout)
    {
        return $this->setData(self::PAGE_LAYOUT, $pageLayout);
    }

    /**
     * Set meta keywords
     *
     * @param string $metaKeywords
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setMetaKeywords($metaKeywords)
    {
        return $this->setData(self::META_KEYWORDS, $metaKeywords);
    }

    /**
     * Set meta description
     *
     * @param string $metaDescription
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setMetaDescription($metaDescription)
    {
        return $this->setData(self::META_DESCRIPTION, $metaDescription);
    }

    /**
     * Set content heading
     *
     * @param string $contentHeading
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setContentHeading($contentHeading)
    {
        return $this->setData(self::CONTENT_HEADING, $contentHeading);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Set sort order
     *
     * @param string $sortOrder
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(self::SORT_ORDER, $sortOrder);
    }

    /**
     * Set layout update xml
     *
     * @param string $layoutUpdateXml
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setLayoutUpdateXml($layoutUpdateXml)
    {
        return $this->setData(self::LAYOUT_UPDATE_XML, $layoutUpdateXml);
    }

    /**
     * Set custom theme
     *
     * @param string $customTheme
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setCustomTheme($customTheme)
    {
        return $this->setData(self::CUSTOM_THEME, $customTheme);
    }

    /**
     * Set custom root template
     *
     * @param string $customRootTemplate
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setCustomRootTemplate($customRootTemplate)
    {
        return $this->setData(self::CUSTOM_ROOT_TEMPLATE, $customRootTemplate);
    }

    /**
     * Set custom layout update xml
     *
     * @param string $customLayoutUpdateXml
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setCustomLayoutUpdateXml($customLayoutUpdateXml)
    {
        return $this->setData(self::CUSTOM_LAYOUT_UPDATE_XML, $customLayoutUpdateXml);
    }

    /**
     * Set custom theme from
     *
     * @param string $customThemeFrom
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setCustomThemeFrom($customThemeFrom)
    {
        return $this->setData(self::CUSTOM_THEME_FROM, $customThemeFrom);
    }

    /**
     * Set custom theme to
     *
     * @param string $customThemeTo
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setCustomThemeTo($customThemeTo)
    {
        return $this->setData(self::CUSTOM_THEME_TO, $customThemeTo);
    }

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }
}
