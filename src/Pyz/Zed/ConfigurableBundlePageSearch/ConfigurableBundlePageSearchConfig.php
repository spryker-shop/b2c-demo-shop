<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ConfigurableBundlePageSearch;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Zed\ConfigurableBundlePageSearch\ConfigurableBundlePageSearchConfig as SprykerConfigurableBundlePageSearch;

class ConfigurableBundlePageSearchConfig extends SprykerConfigurableBundlePageSearch
{
    /**
     * @return string|null
     */
    public function getConfigurableBundlePageSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }

    /**
     * @return string|null
     */
    public function getConfigurableBundlePageEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }

    /**
     * @return string|null
     */
    public function getConfigurableBundleTemplateImageEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }
}
