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
     * @var \Magento\Framework\Stdlib\DateTime
     */
    protected $dateTime;
	
	/**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime $dateTime
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime $dateTime,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->dateTime = $dateTime;
    }
	
	/**
	 * Initialize resource model
     *
     * @return void
	 */
	protected function _construct() {
		$this->_init('blog', 'id');
	}
	
	/**
     *  Check whether identifier is numeric
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return bool
     */
    protected function isNumericIdentifier(\Magento\Framework\Model\AbstractModel $object)
    {
        return preg_match('/^[0-9]+$/', $object->getData('identifier'));
    }

    /**
     *  Check whether identifier is valid
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return bool
     */
    protected function isValidIdentifier(\Magento\Framework\Model\AbstractModel $object)
    {
        return preg_match('/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)?$/', $object->getData('identifier'));
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
     * Retrieves blog title from DB by passed identifier.
     *
     * @param string $identifier
     * @return string|false
     */
    public function getBlogTitleByIdentifier($identifier)
    {
        $select = $this->_getLoadByIdentifierSelect($identifier);
        $select->reset(\Magento\Framework\DB\Select::COLUMNS)->columns('cp.title')->limit(1);
        return $this->getConnection()->fetchOne($select);
    }

    /**
     * Retrieves blog title from DB by passed id.
     *
     * @param string $id
     * @return string|false
     */
    public function getBlogTitleById($id)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from($this->getMainTable(), 'title')->where('id = :id');
        $binds = ['id' => (int)$id];

        return $connection->fetchOne($select, $binds);
    }

    /**
     * Retrieves blog identifier from DB by passed id.
     *
     * @param string $id
     * @return string|false
     */
    public function getBlogIdentifierById($id)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from($this->getMainTable(), 'identifier')->where('id = :id');
        $binds = ['id' => (int)$id];

		return $connection->fetchOne($select, $binds);
    }
	
	/**
     * Process blog data before deleting
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _beforeDelete(\Magento\Framework\Model\AbstractModel $object)
    {
		//TODO: add blog-store link handling
//        $condition = ['id = ?' => (int)$object->getId()];
//        $this->getConnection()->delete($this->getTable('blog_store'), $condition);
        return parent::_beforeDelete($object);
    }

    /**
     * Process blog data before saving
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        if (!$this->isValidIdentifier($object)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The URL key contains capital letters or disallowed symbols.')
            );
        }

        if ($this->isNumericIdentifier($object)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The URL key cannot be made of only numbers.')
            );
        }
        return parent::_beforeSave($object);
    }

    /**
     * Assign blog to store views
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
		//TODO: add blog-store link handling
//        $oldStores = $this->lookupStoreIds($object->getId());
//        $newStores = (array)$object->getStores();
//        if (empty($newStores)) {
//            $newStores = (array)$object->getStoreId();
//        }
//        $table = $this->getTable('cms_page_store');
//        $insert = array_diff($newStores, $oldStores);
//        $delete = array_diff($oldStores, $newStores);
//
//        if ($delete) {
//            $where = ['page_id = ?' => (int)$object->getId(), 'store_id IN (?)' => $delete];
//
//            $this->getConnection()->delete($table, $where);
//        }
//
//        if ($insert) {
//            $data = [];
//
//            foreach ($insert as $storeId) {
//                $data[] = ['page_id' => (int)$object->getId(), 'store_id' => (int)$storeId];
//            }
//
//            $this->getConnection()->insertMultiple($table, $data);
//        }

        return parent::_afterSave($object);
    }

    /**
     * Load an object using 'identifier' field if there's no field specified and value is not numeric
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @param mixed $value
     * @param string $field
     * @return $this
     */
    public function load(\Magento\Framework\Model\AbstractModel $object, $value, $field = null)
    {
        if (!is_numeric($value) && is_null($field)) {
            $field = 'identifier';
        }

        return parent::load($object, $value, $field);
    }

    /**
     * Perform operations after object load
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object)
    {
		//TODO: add blog-store link handling
//        if ($object->getId()) {
//            $stores = $this->lookupStoreIds($object->getId());
//
//            $object->setData('store_id', $stores);
//        }

        return parent::_afterLoad($object);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param \Windigo\Blog\Model\Page $object
     * @return \Magento\Framework\DB\Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
		//TODO: add blog-store link handling
//        if ($object->getStoreId()) {
//            $storeIds = [\Magento\Store\Model\Store::DEFAULT_STORE_ID, (int)$object->getStoreId()];
//            $select->join(
//                ['cms_page_store' => $this->getTable('cms_page_store')],
//                $this->getMainTable() . '.page_id = cms_page_store.page_id',
//                []
//            )->where(
//                'is_active = ?',
//                1
//            )->where(
//                'cms_page_store.store_id IN (?)',
//                $storeIds
//            )->order(
//                'cms_page_store.store_id DESC'
//            )->limit(
//                1
//            );
//        }

        return $select;
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
