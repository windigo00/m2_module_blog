<?php

namespace Windigo\Blog\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
/**
 * Description of Blog
 *
 * @author KuBik
 */
class Blog extends AbstractDb {

	/**
	 * Define main table
	 */
	protected function _construct() {
		$this->_init('blog', 'id');
	}
	
	/**
     * Check if blog identifier exist
     * return blog id if exists
     *
     * @param string $identifier
     * @return int
     */
    public function checkIdentifier($identifier)
    {
        $select = $this->_getLoadByIdentifierSelect($identifier, 1);
        $select->reset(\Magento\Framework\DB\Select::COLUMNS)->columns('cp.id')->limit(1);
        return $this->getConnection()->fetchOne($select);
    }
	
	/**
     * Retrieve load select with filter by identifier and activity
     *
     * @param string $identifier
     * @param int $isActive
     * @return \Magento\Framework\DB\Select
     */
    protected function _getLoadByIdentifierSelect($identifier, $isActive = null)
    {
        $select = $this->getConnection()->select()->from(
            ['cp' => $this->getMainTable()]
        )->where(
            'cp.identifier = ?',
            $identifier
        );

        if (!is_null($isActive)) {
            $select->where('cp.is_active = ?', $isActive);
        }

        return $select;
    }
}
