<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Product;

use Spryker\Shared\ProductBundleStorage\ProductBundleStorageConfig;
use Spryker\Zed\PriceProduct\Dependency\PriceProductEvents;
use Spryker\Zed\Product\ProductConfig as SprykerProductConfig;
use Spryker\Zed\ProductCategory\Dependency\ProductCategoryEvents;
use Spryker\Zed\ProductImage\Dependency\ProductImageEvents;
use Spryker\Zed\ProductLabel\Dependency\ProductLabelEvents;
use Spryker\Zed\ProductReview\Dependency\ProductReviewEvents;
use Spryker\Zed\ProductSearch\Dependency\ProductSearchEvents;

class ProductConfig extends SprykerProductConfig
{
    /**
     * @api
     *
     * @return array<string>
     */
    public function getProductAbstractUpdateMessageBrokerPublisherSubscribedEvents(): array
    {
        return array_merge(parent::getProductAbstractUpdateMessageBrokerPublisherSubscribedEvents(), [
            ProductCategoryEvents::PRODUCT_CATEGORY_PUBLISH,
            ProductCategoryEvents::ENTITY_SPY_PRODUCT_CATEGORY_CREATE,
            ProductCategoryEvents::ENTITY_SPY_PRODUCT_CATEGORY_DELETE,

            ProductLabelEvents::ENTITY_SPY_PRODUCT_LABEL_PRODUCT_ABSTRACT_CREATE,
            ProductLabelEvents::ENTITY_SPY_PRODUCT_LABEL_PRODUCT_ABSTRACT_DELETE,

            PriceProductEvents::PRICE_ABSTRACT_PUBLISH,
            PriceProductEvents::ENTITY_SPY_PRICE_PRODUCT_CREATE,
            PriceProductEvents::ENTITY_SPY_PRICE_PRODUCT_UPDATE,

            ProductReviewEvents::PRODUCT_ABSTRACT_REVIEW_PUBLISH,
            ProductReviewEvents::ENTITY_SPY_PRODUCT_REVIEW_CREATE,
            ProductReviewEvents::ENTITY_SPY_PRODUCT_REVIEW_UPDATE,

            ProductImageEvents::PRODUCT_IMAGE_PRODUCT_ABSTRACT_PUBLISH,

            ProductImageEvents::ENTITY_SPY_PRODUCT_IMAGE_SET_CREATE,
            ProductImageEvents::ENTITY_SPY_PRODUCT_IMAGE_SET_UPDATE,
        ]);
    }

    /**
     * @api
     *
     * @return array<string>
     */
    public function getProductUpdateMessageBrokerPublisherSubscribedEvents(): array
    {
        return array_merge(parent::getProductUpdateMessageBrokerPublisherSubscribedEvents(), [
            ProductBundleStorageConfig::PRODUCT_BUNDLE_PUBLISH,
            ProductBundleStorageConfig::ENTITY_SPY_PRODUCT_BUNDLE_CREATE,
            ProductBundleStorageConfig::ENTITY_SPY_PRODUCT_BUNDLE_UPDATE,

            ProductImageEvents::PRODUCT_IMAGE_PRODUCT_CONCRETE_PUBLISH,
            ProductImageEvents::ENTITY_SPY_PRODUCT_IMAGE_SET_CREATE,
            ProductImageEvents::ENTITY_SPY_PRODUCT_IMAGE_SET_UPDATE,
            ProductImageEvents::ENTITY_SPY_PRODUCT_IMAGE_SET_TO_PRODUCT_IMAGE_CREATE,
            ProductImageEvents::ENTITY_SPY_PRODUCT_IMAGE_SET_TO_PRODUCT_IMAGE_UPDATE,

            PriceProductEvents::PRICE_CONCRETE_PUBLISH,
            PriceProductEvents::ENTITY_SPY_PRICE_PRODUCT_CREATE,
            PriceProductEvents::ENTITY_SPY_PRICE_PRODUCT_UPDATE,

            ProductSearchEvents::ENTITY_SPY_PRODUCT_SEARCH_CREATE,
            ProductSearchEvents::ENTITY_SPY_PRODUCT_SEARCH_UPDATE,
        ]);
    }
}
