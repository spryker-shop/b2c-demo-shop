<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\MessageBroker;

use Spryker\Zed\MessageBroker\MessageBrokerConfig as SprykerMessageBrokerConfig;

class MessageBrokerConfig extends SprykerMessageBrokerConfig
{
    /**
     * @return array<string>
     */
    public function getDefaultWorkerChannels(): array
    {
        return [
            'app-events',
            'payment-events',
            'payment-method-commands',
            'asset-commands',
            'product-review-commands',
            'search-commands',
            'product-commands',
            'tax-commands',
        ];
    }

    /**
     * Specification:
     * - Returns system worker channels used to retrieve service messages.
     *
     * @api
     *
     * @return list<string>
     */
    public function getSystemWorkerChannels(): array
    {
        return [
            'app-events',
        ];
    }
}
