<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MessageBroker;

use Generated\Shared\Transfer\MessageAttributesTransfer;
use Spryker\Zed\MessageBroker\MessageBrokerConfig as SprykerMessageBrokerConfig;

class MessageBrokerConfig extends SprykerMessageBrokerConfig
{
    /**
     * @return array<string>
     */
    public function getDefaultWorkerChannels(): array
    {
        return [
            'product-review-commands',
            'payment-method-commands',
            'payment-commands',
            'payment-events',
            'asset-commands',
            'product-commands',
            'search-commands',
        ];
    }

    /**
     * Defines attributes which should not be logged.
     *
     * @api
     *
     * @return array<string>
     */
    public function getProtectedMessageAttributes(): array
    {
        return [
            MessageAttributesTransfer::AUTHORIZATION,
        ];
    }
}
