<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Shared\GlueStorefrontApiApplicationAuthorizationConnector;

use Spryker\Shared\GlueStorefrontApiApplicationAuthorizationConnector\GlueStorefrontApiApplicationAuthorizationConnectorConfig as SprykerGlueStorefrontApiApplicationAuthorizationConnectorConfig;

class GlueStorefrontApiApplicationAuthorizationConnectorConfig extends SprykerGlueStorefrontApiApplicationAuthorizationConnectorConfig
{
    /**
     * Specification:
     * - Returns a list of protected endpoints.
     * - Structure example:
     * [
     *      '/example' => [
     *          'isRegularExpression' => false,
     *      ],
     *      '/\/example\/.+/' => [
     *          'isRegularExpression' => true,
     *          'methods' => [
     *              'patch',
     *              'delete',
     *          ],
     *      ],
     * ]
     *
     * @return array<string, mixed>
     */
    public function getProtectedPaths(): array
    {
        return [
            '/multi-factor-auth-types' => [
                'isRegularExpression' => false,
            ],
            '/multi-factor-auth-trigger' => [
                'isRegularExpression' => false,
            ],
            '/multi-factor-auth-type-activate' => [
                'isRegularExpression' => false,
            ],
            '/multi-factor-auth-type-verify' => [
                'isRegularExpression' => false,
            ],
            '/multi-factor-auth-type-deactivate' => [
                'isRegularExpression' => false,
            ],
        ];
    }
}
