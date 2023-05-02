<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\SetupFrontend;

use Spryker\Zed\SetupFrontend\SetupFrontendConfig as SprykerSetupFrontendConfig;

class SetupFrontendConfig extends SprykerSetupFrontendConfig
{
    /**
     * @api
     *
     * @return string
     */
    public function getProjectInstallCommand(): string
    {
        return 'npm ci --prefer-offline --legacy-peer-deps';
    }
}
