<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Propel;

use Spryker\Zed\Propel\PropelConfig as SprykerPropelConfig;

class PropelConfig extends SprykerPropelConfig
{
    /**
     * @return array
     */
    public function getProjectPropelSchemaPathPatterns()
    {
        return array_merge(
            [APPLICATION_SOURCE_DIR . '/*/Zed/*/Persistence/Propel/Schema/'],
            parent::getProjectPropelSchemaPathPatterns()
        );
    }
}
