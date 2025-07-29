<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Shared\GlueBackendApiApplicationAuthorizationConnector;

use Spryker\Shared\GlueBackendApiApplicationAuthorizationConnector\GlueBackendApiApplicationAuthorizationConnectorConfig as SprykerGlueBackendApiApplicationAuthorizationConnectorConfig;

class GlueBackendApiApplicationAuthorizationConnectorConfig extends SprykerGlueBackendApiApplicationAuthorizationConnectorConfig
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
            '/\/warehouse-user-assignments(?:\/[^\/]+)?\/?$/' => [
                'isRegularExpression' => true,
            ],
            '/push-notification-subscriptions' => [
                'isRegularExpression' => false,
            ],
            '/\/push-notification-providers.*/' => [
                'isRegularExpression' => true,
            ],
            '/warehouse-tokens' => [
                'isRegularExpression' => false,
                'methods' => [
                    'post',
                ],
            ],
            '/\/picking-lists.*/' => [
                'isRegularExpression' => true,
                'methods' => [
                    'patch',
                ],
            ],
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
