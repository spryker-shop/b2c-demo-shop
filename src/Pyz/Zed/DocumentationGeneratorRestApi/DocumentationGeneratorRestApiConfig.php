<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\DocumentationGeneratorRestApi;

use Spryker\Zed\DocumentationGeneratorRestApi\DocumentationGeneratorRestApiConfig as SprykerDocumentationGeneratorRestApiConfig;

class DocumentationGeneratorRestApiConfig extends SprykerDocumentationGeneratorRestApiConfig
{
    /**
     * @return bool
     */
    public function isNestedRelationshipsEnabled(): bool
    {
        return true;
    }
}
