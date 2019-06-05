<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ContentBannerDataImport;

use Spryker\Zed\ContentBannerDataImport\ContentBannerDataImportConfig as SprykerContentBannerDataImportConfig;

class ContentBannerDataImportConfig extends SprykerContentBannerDataImportConfig
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
