<?php
namespace Windigo\Blog\Model;

use Windigo\Blog\Api\Data\BlogInterface,
	Magento\Framework\DataObject\IdentityInterface,
	Magento\Framework\Model\AbstractModel
		;

/**
 * Blog Model
 *
 * @method \Windigo\Blog\Model\Resource\Blog _getResource()
 * @method \Windigo\Blog\Model\Resource\Blog getResource()
 */
class Blog extends AbstractModel implements BlogInterface, IdentityInterface {
    /**#@+
     * Blog's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/ 
	
	/**
	 * Define resource model
	 */
	protected function _construct()
	{
	   $this->_init('Windigo\Blog\Model\Resource\Blog');
	}
	
	/**
     * Check if blog identifier exist
     * return blog id if exists
     *
     * @param string $identifier
     * @return int
     */
    public function checkUrlKey($identifier)
    {
        return $this->_getResource()->checkIdentifier($identifier);
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
	
	public function getUrl() {
		return $this->getIdentifier();
	}

    /**
     * Load No-Route Blog
     *
     * @return \Windigo\Blog\Model\Blog
     */
    public function noRouteBlog()
    {
        return $this->load(self::NOROUTE_BLOG_ID, $this->getIdFieldName());
    }

    /**
     * Prepare blog's statuses.
     * Available event blog_get_available_statuses to customize statuses.
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
        return parent::getData(self::BLOG_ID);
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
        return $this->setData(self::BLOG_ID, $id);
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