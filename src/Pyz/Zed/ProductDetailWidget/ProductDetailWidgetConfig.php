<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetailPageWidget;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class ProductDetailWidgetConfig extends AbstractBundleConfig
{
    /**
     * Used as `item_type` for touch mechanism.
     *
     * @var string
     */
    public const RESOURCE_TYPE_PRODUCT = 'product';

    /**
     * Default URL to redirect to when no specific URL is provided.
     *
     * @var string
     */
    protected const REDIRECT_URL_DEFAULT = '/product-detail-page';

    /**
     * Paths to the product detail configuration files.
     *
     * @var string[]
     */
    protected const CONFIG_FILE_PATHS = [
        APPLICATION_SOURCE_DIR . '/ProductDetailPageWidget/Resources/config/product-detail-page.yml',
        APPLICATION_VENDOR_DIR . '/some-vendor/some-module/src/SomeModule/Resources/config/product-detail-page.yml',
    ];

    /**
     * Returns paths to the product detail configuration files.
     *
     * @return array<string>
     * @api
     */
    public function getProductDetailConfigFilePaths(): array
    {
        /** @var array<string> $sourceConfigFiles */
        $sourceConfigFiles = glob(APPLICATION_SOURCE_DIR . '/*/*/*/Resources/config/product-detail-page.yml', GLOB_NOSORT);

        /** @var array<string> $vendorConfigFiles */
        $vendorConfigFiles = glob(APPLICATION_VENDOR_DIR . '/*/*/src/*/*/*/Resources/config/product-detail-page.yml', GLOB_NOSORT);

        $paths = array_merge(
            $sourceConfigFiles,
            $vendorConfigFiles,
        );

        return $paths;
    }

    /**
     * Returns the default redirect URL for the widget.
     *
     * @return string
     * @api
     */
    public function getDefaultRedirectUrl(): string
    {
        return static::REDIRECT_URL_DEFAULT;
    }
}
