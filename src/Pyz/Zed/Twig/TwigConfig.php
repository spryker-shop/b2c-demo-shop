<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Twig;

use Spryker\Zed\Twig\TwigConfig as SprykerTwigConfig;

class TwigConfig extends SprykerTwigConfig
{
    /**
     * @project Only needed in Project, not in demoshop
     *
     * @param array $paths
     *
     * @return array
     */
    protected function addCoreTemplatePaths(array $paths)
    {
        $paths = parent::addCoreTemplatePaths($paths);
        $paths[] = $this->getBundlesDirectory() . '/%2$s/src/Spryker/Zed/%1$s/Presentation/';

        return $paths;
    }

    /**
     * @project Only needed in Project, not in demoshop
     *
     * @return array
     */
    public function getZedDirectoryPathPatterns()
    {
        $directories = glob('vendor/spryker/spryker/Bundles/CmsSlot*/src/*/Zed/*/Presentation', GLOB_NOSORT | GLOB_ONLYDIR);
        $directories = array_merge(
            $directories,
            parent::getZedDirectoryPathPatterns()
        );

        sort($directories);

        return $directories;
    }

    /**
     * @project Only needed in Project, not in demoshop
     *
     * @return array
     */
    public function getYvesDirectoryPathPatterns()
    {
        $themeNameDefault = $this->getSharedConfig()->getYvesThemeNameDefault();
        $directories = glob(APPLICATION_VENDOR_DIR . '/*/*/Bundles/CmsSlot*/src/*/Yves/*/Theme/' . $themeNameDefault, GLOB_NOSORT | GLOB_ONLYDIR);

        $directories = array_merge(
            $directories,
            parent::getYvesDirectoryPathPatterns()
        );

        return $directories;
    }
}
