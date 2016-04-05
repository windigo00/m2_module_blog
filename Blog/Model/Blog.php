<?php
namespace Windigo\Blog\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Blog Model
 *
 * @method \Windigo\Blog\Model\Resource\Blog _getResource()
 * @method \Windigo\Blog\Model\Resource\Blog getResource()
 */
class Blog extends AbstractModel {
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
}