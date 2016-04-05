<?php
namespace Windigo\Blog\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Description of Post
 *
 * @author KuBik
 * 
 * @method \Windigo\Blog\Model\Resource\Post _getResource()
 * @method \Windigo\Blog\Model\Resource\Post getResource()
 */
class Post extends AbstractModel {
	/**#@+
     * Post's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/ 
	
	/**
	 * Define resource model
	 */
	protected function _construct()
	{
	   $this->_init('Windigo\Blog\Model\Resource\Post');
	}
}
