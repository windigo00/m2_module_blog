<?php
namespace Windigo\Blog\Model;

/**
 * Post Model
 *
 * @method \Windigo\Blog\Model\ResourceModel\Post _getResource()
 * @method \Windigo\Blog\Model\ResourceModel\Post getResource()
 *
 * @author windigo
 */
class Post extends \Magento\Framework\Model\AbstractModel implements BlogInterface, IdentityInterface{
	
	const NOROUTE_POST_ID = 0;
	/**#@+
     * Blog post's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/

    /**
     * cache tag
     */
    const CACHE_TAG = 'blog-post';

    /**
     * @var string
     */
    protected $_cacheTag = 'blog-post';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'blog-post';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Windigo\Blog\Model\ResourceModel\Post');
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
            return $this->noRoutePost();
        }
        return parent::load($id, $field);
    }

    /**
     * Load No-Route Post
     *
     * @return \Windigo\Blog\Model\Post
     */
    public function noRoutePost()
    {
        return $this->load(self::NOROUTE_POST_ID, $this->getIdFieldName());
    }

    /**
     * Prepare post's statuses.
     * Available event blog_post_get_available_statuses to customize statuses.
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
        return parent::getData(self::POST_ID);
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
