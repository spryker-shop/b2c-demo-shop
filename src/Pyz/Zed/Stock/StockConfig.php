<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Stock;

use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Zed\Stock\StockConfig as SprykerStockConfig;

class StockConfig extends SprykerStockConfig
{
    /**
     * @return array<string, list<string>>
     */
    public function getStoreToWarehouseMapping(): array
    {
        return [
            'DE' => [
                'Warehouse1',
                'Warehouse2',
            ],
            'AT' => [
                'Warehouse2',
            ],
            'US' => [
                'Warehouse2',
            ],
        ];
    }

    public function isConditionalStockUpdateApplied(): bool
    {
        return true;
    }

    public function getEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }
}
