<?php
/**
 * Faonni
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_WishlistScore
 * @copyright   Copyright (c) 2017 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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
