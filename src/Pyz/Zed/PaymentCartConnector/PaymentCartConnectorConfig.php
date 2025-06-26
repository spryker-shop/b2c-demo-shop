<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\PaymentCartConnector;

use Spryker\Zed\PaymentCartConnector\PaymentCartConnectorConfig as SprykerPaymentCartConnectorConfig;

class PaymentCartConnectorConfig extends SprykerPaymentCartConnectorConfig
{
    /**
     * @var list<string>
     */
    protected const EXCLUDED_PAYMENT_METHODS = [
        'PayPal Express',
    ];
}
