<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\SessionRedis;

use Spryker\Yves\SessionRedis\Plugin\SessionRedisLockingExclusion\BotSessionRedisLockingExclusionConditionPlugin;
use Spryker\Yves\SessionRedis\Plugin\SessionRedisLockingExclusion\UrlSessionRedisLockingExclusionConditionPlugin;
use Spryker\Yves\SessionRedis\SessionRedisDependencyProvider as SprykerSessionRedisDependencyProvider;

class SessionRedisDependencyProvider extends SprykerSessionRedisDependencyProvider
{
    /**
     * @return array<\Spryker\Yves\SessionRedisExtension\Dependency\Plugin\SessionRedisLockingExclusionConditionPluginInterface>
     */
    protected function getSessionRedisLockingExclusionConditionPlugins(): array
    {
        return [
            new UrlSessionRedisLockingExclusionConditionPlugin(),
            new BotSessionRedisLockingExclusionConditionPlugin(),
        ];
    }
}
