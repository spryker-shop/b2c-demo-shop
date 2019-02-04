<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CmsPageDataImport;

use Spryker\Zed\CmsPageDataImport\CmsPageDataImportConfig as SprykerCmsPageDataImportConfig;

class CmsPageDataImportConfig extends SprykerCmsPageDataImportConfig
{
    /**
     * @return string
     */
    protected function getModuleRoot(): string
    {
        $moduleRoot = realpath(APPLICATION_ROOT_DIR);

        return $moduleRoot . DIRECTORY_SEPARATOR;
    }
}
