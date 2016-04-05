<?php

namespace Windigo\Blog\Model\Resource\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Description of Collection
 *
 * @author KuBik
 */
class Collection extends AbstractCollection {

	/**
	 * Define model & resource model
	 */
	protected function _construct() {
		$this->_init(
				'Windigo\Blog\Model\Post', 'Windigo\Blog\Model\Resource\Post'
		);
	}

}
