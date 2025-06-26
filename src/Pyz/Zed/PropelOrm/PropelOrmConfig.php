<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\PropelOrm;

use Spryker\Zed\PropelOrm\PropelOrmConfig as SprykerPropelOrmConfig;

class PropelOrmConfig extends SprykerPropelOrmConfig
{
    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function isBooleanCastingEnabled(): bool
    {
        return true;
    }
}
