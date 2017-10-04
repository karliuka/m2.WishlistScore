<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\WishlistScore\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Cache\InstanceFactory;
use Magento\Framework\App\Cache\StateInterface;
use Magento\Framework\Cache\ConfigInterface;
use Faonni\WishlistScore\Helper\Data as WishlistScoreHelper;

/**
 * WishlistScore cache observer
 */
class CacheObserver implements ObserverInterface
{
    /**
	 * Cache config
	 *
     * @var \Magento\Framework\Cache\ConfigInterface
     */
    protected $_config;
	
    /**
	 * Cache instance factory
	 *
     * @var \Magento\Framework\App\Cache\InstanceFactory
     */
    protected $_factory;

    /**
	 * Cache status instance
	 *
     * @var \Magento\Framework\App\Cache\StateInterface
     */
    protected $_cacheState;
    
    /**
     * WishlistScore helper
     *
     * @var \Faonni\WishlistScore\Helper\Data
     */
    protected $_wishlistScoreHelper;    
    
    /**
     * Initialize observer
     *
     * @param ConfigInterface $config
     * @param InstanceFactory $factory
     * @param StateInterface $cacheState
	 * @param WishlistScoreHelper $wishlistScoreHelper
     */
    public function __construct(
        ConfigInterface $config,
		InstanceFactory $factory,
		StateInterface $cacheState,
		WishlistScoreHelper $wishlistScoreHelper
    ) {
        $this->_config = $config;
		$this->_factory = $factory;
		$this->_cacheState = $cacheState;
		$this->_wishlistScoreHelper = $wishlistScoreHelper;		
    }
       	
    /**
     * Clean cache
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {		
		$type = 'full_page';
		if ($this->_wishlistScoreHelper->isEnabled() &&
			$this->_cacheState->isEnabled($type)
		) {
			$cacheManager = $this->_getTypeInstance($type);
			if ($cacheManager) {
				$cacheManager->clean(
					\Zend_Cache::CLEANING_MODE_MATCHING_TAG, 
					$this->_wishlistScoreHelper->getIdentities(
						$observer->getEvent()->getProduct()
					)
				);
			}
		}
        return $this;
    }
	
    /**
     * Get cache class by cache type from configuration
     *
     * @param string $type
     * @return \Magento\Framework\Cache\FrontendInterface
     * @throws \UnexpectedValueException
     */
    protected function _getTypeInstance($type)
    {
        $config = $this->_config->getType($type);
        if (!isset($config['instance'])) {
            return null;
        }
        return $this->_factory->get($config['instance']);
    }	
}  
