<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Application\Communication;

use Spryker\Shared\Auth\AuthConstants;
use Spryker\Shared\Config\Config;
use Spryker\Zed\Api\ApiConfig;
use Spryker\Zed\Application\Communication\ZedBootstrap as SprykerZedBootstrap;

class ZedBootstrap extends SprykerZedBootstrap
{
    /**
     * @SuppressWarnings(PHPMD)
     *
     * @return void
     */
    protected function setUp()
    {
        if (!empty($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], ApiConfig::ROUTE_PREFIX_API_REST) === 0) {
            $this->registerApiServiceProvider();
            return;
        }

        parent::setUp();
    }

    /**
     * @return bool
     */
    protected function isAuthenticationEnabled()
    {
        return Config::get(AuthConstants::AUTH_ZED_ENABLED, true);
    }
}
