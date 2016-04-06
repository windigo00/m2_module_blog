<?php
namespace Windigo\Blog\Api\Data;

/**
 * Blog interface.
 * @api
 */
interface BlogInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const BLOG_ID                  = 'id';
    const IDENTIFIER               = 'identifier';
    const TITLE                    = 'title';
    const META_KEYWORDS            = 'meta_keywords';
    const META_DESCRIPTION         = 'meta_description';
    const CONTENT                  = 'content';
    const CREATION_TIME            = 'creation_time';
    const UPDATE_TIME              = 'update_time';
    const IS_ACTIVE                = 'is_active';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get meta keywords
     *
     * @return string|null
     */
    public function getMetaKeywords();

    /**
     * Get meta description
     *
     * @return string|null
     */
    public function getMetaDescription();

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setId($id);

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setIdentifier($identifier);

    /**
     * Set title
     *
     * @param string $title
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setTitle($title);

    /**
     * Set meta keywords
     *
     * @param string $metaKeywords
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setMetaKeywords($metaKeywords);

    /**
     * Set meta description
     *
     * @param string $metaDescription
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setMetaDescription($metaDescription);

    /**
     * Set content
     *
     * @param string $content
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setContent($content);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setUpdateTime($updateTime);

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return \Windigo\Blog\Api\Data\BlogInterface
     */
    public function setIsActive($isActive);
}
