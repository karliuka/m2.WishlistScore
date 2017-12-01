# Magento2 WishlistScore
Extension displays how many times a product has been added to wishlist.

### Product View page

<img alt="Magento2 WishlistScore" src="https://karliuka.github.io/m2/wishlist-score/product.page.png" style="width:100%"/>

### Configuration page

<img alt="Magento2 WishlistScore" src="https://karliuka.github.io/m2/wishlist-score/config.png" style="width:100%"/>

## Install with Composer as you go

1. Go to Magento2 root folder

2. Enter following commands to install module:

    ```bash
    composer require faonni/module-wishlist-score
    ```
   Wait while dependencies are updated.

3. Enter following commands to enable module:

    ```bash
	php bin/magento setup:upgrade
	php bin/magento setup:static-content:deploy

