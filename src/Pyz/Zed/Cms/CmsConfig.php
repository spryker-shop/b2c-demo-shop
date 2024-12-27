<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Cms;

use Spryker\Zed\Cms\CmsConfig as SprykerCmsConfig;

class CmsConfig extends SprykerCmsConfig
{
    /**
     * @return bool
     */
    public function appendPrefixToCmsPageUrl(): bool
    {
        return true;
    }
}
