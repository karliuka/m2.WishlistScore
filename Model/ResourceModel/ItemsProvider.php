<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\WishlistScore\Model\ResourceModel;

use Magento\Framework\App\ResourceConnection;

/**
 * WishlistScore items provider
 */
class ItemsProvider
{
    /** 
     * Resource Connection
     * 
     * @var \Magento\Framework\App\ResourceConnection 
     */
    private $_resource;
    
    /**
     * Initialize resource model
	 *
     * @param \Magento\Framework\App\ResourceConnection $resource
     */
    public function __construct(
		ResourceConnection $resource
	) {
        $this->_resource = $resource;
    }

    /**
     * Retrieve counter products
     * 
     * @param integer $productId
     * @param integer $storeId
     * @return array
     */
    public function getCounter($productId, $storeId)
    {
		$connection = $this->_resource->getConnection();
        $select = $connection->select();
		$select
			->from(
				['i' => $this->_resource->getTableName('wishlist_item')],
				['count' => new \Zend_Db_Expr('COUNT(i.wishlist_id)')]
			)
			->join(
				['w' => $this->_resource->getTableName('wishlist')],
				"i.wishlist_id = w.wishlist_id",
				[]
			)
			->where('i.store_id = ?', $storeId)
			->where('i.product_id = ?', $productId);		

		return $connection->fetchOne($select);
    }
}
