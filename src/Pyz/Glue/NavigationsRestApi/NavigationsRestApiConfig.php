<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\NavigationsRestApi;

use Spryker\Glue\NavigationsRestApi\NavigationsRestApiConfig as SprykerNavigationsRestApiConfig;

class NavigationsRestApiConfig extends SprykerNavigationsRestApiConfig
{
    /**
     * {@inheritDoc}
     *
     * @return array
     */
    public function getNavigationTypeToUrlResourceIdFieldMapping(): array
    {
        return [
            'category' => 'fkResourceCategorynode',
            'cms_page' => 'fkResourcePage',
        ];
    }
}
