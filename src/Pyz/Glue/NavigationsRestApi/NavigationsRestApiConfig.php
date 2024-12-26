<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Glue\NavigationsRestApi;

use Spryker\Glue\NavigationsRestApi\NavigationsRestApiConfig as SprykerNavigationsRestApiConfig;

class NavigationsRestApiConfig extends SprykerNavigationsRestApiConfig
{
    /**
     * {@inheritDoc}
     *
     * @return array<string>
     */
    public function getNavigationTypeToUrlResourceIdFieldMapping(): array
    {
        return [
            'category' => 'fkResourceCategorynode',
            'cms_page' => 'fkResourcePage',
        ];
    }
}
