<?php
namespace Windigo\Blog\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
/**
 * Description of Post
 *
 * @author KuBik
 */
class Post extends AbstractDb {
	/**
	 * Define main table
	 */
	protected function _construct() {
		$this->_init('blog_post', 'id');
	}
}
