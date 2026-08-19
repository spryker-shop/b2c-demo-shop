<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ShipmentGui;

use Spryker\Zed\Kernel\Communication\Form\FormTypeInterface;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\MoneyGui\Communication\Plugin\Form\MoneyCollectionFormTypePlugin;
use Spryker\Zed\ShipmentGui\ShipmentGuiDependencyProvider as SprykerShipmentGuiDependencyProvider;
use Spryker\Zed\Store\Communication\Plugin\Form\StoreRelationToggleFormTypePlugin;

class ShipmentGuiDependencyProvider extends SprykerShipmentGuiDependencyProvider
{
    protected function getMoneyCollectionFormTypePlugin(Container $container): FormTypeInterface // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter
    {
        return new MoneyCollectionFormTypePlugin();
    }

    protected function getStoreRelationFormTypePlugin(): FormTypeInterface
    {
        return new StoreRelationToggleFormTypePlugin();
    }
}
