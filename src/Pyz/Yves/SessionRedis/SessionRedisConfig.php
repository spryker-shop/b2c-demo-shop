<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\SessionRedis;

use Spryker\Yves\SessionRedis\SessionRedisConfig as SprykerSessionRedisConfig;

class SessionRedisConfig extends SprykerSessionRedisConfig
{
    /**
     * Specification:
     * - Returns URL patterns that are excluded from Redis locking.
     * - These patterns are used to identify requests that don't require session locking.
     *
     * @api
     *
     * @return list<string>
     */
    public function getSessionRedisLockingExcludedUrlPatterns(): array
    {
        return [
            '/^.*\/error-page\/*.*$/',
            '/^.*\/health-check$/',
        ];
    }

    /**
     * Specification:
     * - Returns user agent strings used to identify bot traffic.
     * - Bot traffic is excluded from Redis session locking for better performance.
     *
     * @api
     *
     * @return list<string>
     */
    public function getSessionRedisLockingExcludedBotUserAgents(): array
    {
        return [
            'Googlebot',
            'bingbot',
            'Baiduspider',
            'YandexBot',
            'DuckDuckBot',
            'Sogou',
            'ia_archiver',
            'facebookexternalhit',
            'Twitterbot',
            'LinkedInBot',
            'Slackbot',
            'WhatsApp',
            'Discordbot',
            'AhrefsBot',
            'Applebot',
            'msnbot',
            'MJ12bot',
            'SEMrushBot',
            'PetalBot',
            'SeznamBot',
            'AdsBot-Google',
            'crawler',
            'spider',
            'robot',
            'bot/',
        ];
    }
}
