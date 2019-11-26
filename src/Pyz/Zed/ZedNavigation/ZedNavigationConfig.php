<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ZedNavigation;

use Spryker\Zed\ZedNavigation\ZedNavigationConfig as SprykerZedNavigationConfig;

class ZedNavigationConfig extends SprykerZedNavigationConfig
{
    /**
     * @project Only needed in Project, not in demoshop
     *
     * @return array
     */
    public function getNavigationSchemaPathPattern()
    {
        $paths = parent::getNavigationSchemaPathPattern();
        $paths = $this->addSprykerFilePath($paths);

        return $paths;
    }

    /**
     * @project Only needed in Project, not in demoshop
     *
     * @param array $paths
     *
     * @return array
     */
    private function addSprykerFilePath($paths)
    {
        $paths[] = APPLICATION_VENDOR_DIR . '/spryker/spryker/Bundles/CmsSlot*/src/*/Zed/*/Communication';

        return $paths;
    }
}
