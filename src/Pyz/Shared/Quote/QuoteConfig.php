<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Shared\Quote;

use Spryker\Shared\Quote\QuoteConfig as SprykerQuoteConfig;

class QuoteConfig extends SprykerQuoteConfig
{
    /**
     * @return string
     */
    public function getStorageStrategy(): string
    {
        return static::STORAGE_STRATEGY_DATABASE;
    }
}
