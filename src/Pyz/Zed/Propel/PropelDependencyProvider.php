<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Propel;

use Spryker\Zed\Propel\Communication\Plugin\Propel\ForeignKeyIndexPropelSchemaElementFilterPlugin;
use Spryker\Zed\Propel\PropelDependencyProvider as SprykerPropelDependencyProvider;

class PropelDependencyProvider extends SprykerPropelDependencyProvider
{
    /**
     * @return \Spryker\Zed\Propel\Dependency\Plugin\PropelSchemaElementFilterPluginInterface[]
     */
    protected function getPropelSchemaElementFilterPlugins(): array
    {
        return [
            new ForeignKeyIndexPropelSchemaElementFilterPlugin(),
        ];
    }
}
