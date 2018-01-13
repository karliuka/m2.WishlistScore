<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\WishlistScore\Block\Catalog\Product\View\Wishlist;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\DataObject\IdentityInterface;
use Faonni\WishlistScore\Helper\Data as WishlistScoreHelper;
use Faonni\WishlistScore\Model\ResourceModel\ItemsProvider;

/**
 * WishlistScore score block
 */
class Score extends Template implements IdentityInterface
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;	
	
    /**
     * Currently viewed product
     *
     * @var \Magento\Catalog\Model\Product
     */
    protected $_currentProduct;		
	
    /**
	 * WishlistScore items provider
	 *
     * @var \Faonni\WishlistScore\Model\ResourceModel\ItemsProvider
     */
    protected $_itemsProvider;  
	
    /**
     * WishlistScore helper
     *
     * @var \Faonni\WishlistScore\Helper\Data
     */
    protected $_wishlistScoreHelper;  
    
    /**
     * Initialize block
	 *
     * @param Context $context	 
     * @param Registry $coreRegistry
     * @param ItemsProvider $itemsProvider
	 * @param WishlistScoreHelper $wishlistScoreHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
		Registry $coreRegistry,
		ItemsProvider $itemsProvider,
		WishlistScoreHelper $wishlistScoreHelper,
        array $data = []		
    ) {
        $this->_coreRegistry = $coreRegistry;
		$this->_itemsProvider = $itemsProvider;
		$this->_wishlistScoreHelper = $wishlistScoreHelper;

        parent::__construct(
			$context,
			$data
		);
    }
	
    /**
     * Retrieve currently viewed product object
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        if (!$this->_currentProduct) {           
            $this->_currentProduct = $this->_coreRegistry
				->registry('product');           
        }
        return $this->_currentProduct;
    }
    
    /**
     * Check whether the wishlist score is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_wishlistScoreHelper->isEnabled();
    } 
        
    /**
     * Retrieve counter products
     *
     * @return int
     */  	
	public function getCounter()
	{
		$product = $this->getProduct();
		if ($product) {
			return (int)$this->_itemsProvider
				->getCounter($product->getId(), $product->getStoreId());		
		}		
		return 0;
	}
	
    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
		return $this->_wishlistScoreHelper->getIdentities(
			$this->getProduct()
		);
	}
}
