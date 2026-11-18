<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Shared\Configuration;

use Spryker\Shared\Configuration\ConfigurationConfig as SprykerConfigurationConfig;
use Spryker\Shared\Configuration\ConfigurationConstants;

class ConfigurationConfig extends SprykerConfigurationConfig
{
    /**
     * @uses \Spryker\Shared\Store\StoreConstants::SCOPE_STORE
     */
    public const string SCOPE_STORE = 'store';

    /**
     * @return array<string>
     */
    public function getAvailableScopes(): array
    {
        $availableScopes = parent::getAvailableScopes();
        $availableScopes[] = static::SCOPE_STORE;

        return $availableScopes;
    }

    /**
     * @return array<string, string|null>
     */
    public function getScopeHierarchy(): array
    {
        $scopeHierarchy = parent::getScopeHierarchy();
        $scopeHierarchy[static::SCOPE_STORE] = ConfigurationConstants::SCOPE_GLOBAL;

        return $scopeHierarchy;
    }
}
