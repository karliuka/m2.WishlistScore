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
namespace Faonni\WishlistScore\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Wishlist\Helper\Data as WishlistHelper;
use Magento\Catalog\Model\Product;

/**
 * WishlistScore Data Helper
 */
class Data extends AbstractHelper
{
    /**
     * Cache tag
     */
    const CACHE_TAG = 'WISHLIST_SCORE';
    	
    /**
     * Enabled config path
     */
    const XML_WISHLIST_SCORE_ENABLED = 'wishlist/score/enabled';	
	
    /**
     * Wishlist helper
     *
     * @var \Magento\Wishlist\Helper\Data
     */
    protected $_wishlistHelper;	
	
    /**
     * Initialize helper
	 *
     * @param Context $context	 
	 * @param WishlistHelper $wishlistHelper 
     */
    public function __construct(
        Context $context,
		WishlistHelper $wishlistHelper 
    ) {
		$this->_wishlistHelper = $wishlistHelper;

        parent::__construct(
			$context
		);
    }
    
    /**
     * Check whether the wishlist score is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_getConfig(self::XML_WISHLIST_SCORE_ENABLED) &&
			$this->isWishListAllowed();
    } 
    	
    /**
     * Check whether the wishlist is allowed
     *
     * @return string
     */
    public function isWishListAllowed()
    {
        return $this->_wishlistHelper->isAllow();
    }
    
    /**
     * Return unique ID(s) for each object in system
     *
     * @param Magento\Catalog\Model\Product $product
     * @return string[]
     */
    public function getIdentities(Product $product)
    {
		if ($product) {
			return [self::CACHE_TAG . '_' . $product->getId()];	
		}
		return [];	
	}
	    
    /**
     * Retrieve store configuration data
     *
     * @param string $path
     * @return string|null
     */
    protected function _getConfig($path)
    {
        return $this->scopeConfig->getValue(
			$path, 
			ScopeInterface::SCOPE_STORE
		);
    }     
}
