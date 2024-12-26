<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\SearchElasticsearch;

use Spryker\Zed\SearchElasticsearch\SearchElasticsearchConfig as SprykerSearchElasticsearchConfig;

/**
 * @method \Spryker\Shared\SearchElasticsearch\SearchElasticsearchConfig getSharedConfig()
 */
class SearchElasticsearchConfig extends SprykerSearchElasticsearchConfig
{
    /**
     * @return list<string>
     */
    public function getJsonSchemaDefinitionDirectories(): array
    {
        $directories = parent::getJsonSchemaDefinitionDirectories();
        $directories[] = sprintf('%s/src/Pyz/Shared/*/Schema/', APPLICATION_ROOT_DIR);

        return $directories;
    }
}
