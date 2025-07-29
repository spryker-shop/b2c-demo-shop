<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductBundle\Dependency;

interface ProductBundleEvents
{
    /**
     * Specification:
     * - Represents spy_product_bundle entity creation.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_PRODUCT_BUNDLE_CREATE = 'Entity.spy_product_bundle.create';

    /**
     * Specification:
     * - Represents spy_product_bundle entity changes.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_PRODUCT_BUNDLE_UPDATE = 'Entity.spy_product_bundle.update';

    /**
     * Specification:
     * - Represents spy_product_bundle entity deletion.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_PRODUCT_BUNDLE_DELETE = 'Entity.spy_product_bundle.delete';
}
