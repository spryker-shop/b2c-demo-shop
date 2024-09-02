<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductAttributeGui;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use Spryker\Zed\ProductAttributeGui\ProductAttributeGuiConfig as SpyConfig;

class ProductAttributeGuiConfig extends SpyConfig
{
    /**
     * @var string
     */
    public const API_TOKEN = 'API_TOKEN';

    /**
     * @api
     *
     * @return string|null
     */
    public function getCarbonEmissionToken()
    {
        return $this->get(static::API_TOKEN);
    }
}
