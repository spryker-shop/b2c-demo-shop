<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ContentProductSetDataImport;

use Spryker\Zed\ContentProductSetDataImport\ContentProductSetDataImportConfig as SprykerContentProductSetDataImportConfig;

class ContentProductSetDataImportConfig extends SprykerContentProductSetDataImportConfig
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
