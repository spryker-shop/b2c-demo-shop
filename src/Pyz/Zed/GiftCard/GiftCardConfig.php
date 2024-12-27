<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\GiftCard;

use Spryker\Shared\DummyPayment\DummyPaymentConfig;
use Spryker\Shared\Shipment\ShipmentConfig;
use Spryker\Zed\GiftCard\GiftCardConfig as SprykerGiftCardConfig;

class GiftCardConfig extends SprykerGiftCardConfig
{
    /**
     * @return array<string>
     */
    public function getGiftCardPaymentMethodBlacklist(): array
    {
        return [
            DummyPaymentConfig::PAYMENT_METHOD_INVOICE,
        ];
    }

    /**
     * @return array<string>
     */
    public function getGiftCardOnlyShipmentMethods(): array
    {
        return [
            ShipmentConfig::SHIPMENT_METHOD_NAME_NO_SHIPMENT,
        ];
    }
}
