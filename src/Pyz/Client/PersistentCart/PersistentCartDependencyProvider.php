<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Client\PersistentCart;

use Spryker\Client\DiscountPromotion\Plugin\AddDiscountPromotionPersistentCartRequestExpanderPlugin;
use Spryker\Client\PersistentCart\PersistentCartDependencyProvider as SprykerPersistentCartDependencyProvider;
use Spryker\Client\ProductConfigurationPersistentCart\Plugin\PersistentCart\ProductConfigurationPersistentCartRequestExpanderPlugin;

class PersistentCartDependencyProvider extends SprykerPersistentCartDependencyProvider
{
    /**
     * @return array<\Spryker\Client\PersistentCartExtension\Dependency\Plugin\PersistentCartChangeExpanderPluginInterface>
     */
    protected function getChangeRequestExtendPlugins(): array
    {
        return [
            new AddDiscountPromotionPersistentCartRequestExpanderPlugin(),
            new ProductConfigurationPersistentCartRequestExpanderPlugin(),
        ];
    }
}
