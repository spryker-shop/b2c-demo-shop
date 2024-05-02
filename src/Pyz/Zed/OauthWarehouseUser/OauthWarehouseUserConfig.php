<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\OauthWarehouseUser;

use Spryker\Zed\OauthWarehouseUser\OauthWarehouseUserConfig as SprykerOauthWarehouseUserConfig;

class OauthWarehouseUserConfig extends SprykerOauthWarehouseUserConfig
{
    /**
     * Specification:
     * - Returns a list of endpoints access to which is allowed for warehouse users.
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
     * @api
     *
     * @return array<string, mixed>
     */
    public function getAllowedForWarehouseUserPaths(): array
    {
        return [
            '/\/warehouse-user-assignments(?:\/[^\/]+)?\/?$/' => [
                'isRegularExpression' => true,
                'methods' => [
                    'get',
                    'getCollection',
                    'patch',
                ],
            ],
            '/\/picking-lists.*/' => [
                'isRegularExpression' => true,
                'methods' => [
                    'patch',
                ],
            ],
            '/\/push-notification-providers.*/' => [
                'isRegularExpression' => true,
            ],
            '/push-notification-subscriptions' => [
                'isRegularExpression' => false,
            ],
            '/warehouse-tokens' => [
                'isRegularExpression' => false,
                'methods' => [
                    'post',
                ],
            ],
        ];
    }
}
