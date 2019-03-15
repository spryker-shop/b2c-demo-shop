<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductBundle\Dependency;

interface ProductBundleEvents
{
    /**
     * Specification:
     * - Represents spy_product_bundle entity creation.
     *
     * @api
     */
    public const ENTITY_SPY_PRODUCT_BUNDLE_CREATE = 'Entity.spy_product_bundle.create';

    /**
     * Specification:
     * - Represents spy_product_bundle entity changes.
     *
     * @api
     */
    public const ENTITY_SPY_PRODUCT_BUNDLE_UPDATE = 'Entity.spy_product_bundle.update';

    /**
     * Specification:
     * - Represents spy_product_bundle entity deletion.
     *
     * @api
     */
    public const ENTITY_SPY_PRODUCT_BUNDLE_DELETE = 'Entity.spy_product_bundle.delete';
}
