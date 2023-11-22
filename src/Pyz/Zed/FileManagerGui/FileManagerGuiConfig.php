<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\FileManagerGui;

use Spryker\Zed\FileManagerGui\FileManagerGuiConfig as SprykerFileManagerGuiConfig;

class FileManagerGuiConfig extends SprykerFileManagerGuiConfig
{
    /**
     * @var bool
     */
    protected const IS_FILE_EXTENSION_VALIDATION_ENABLED = true;

    /**
     * @var bool
     */
    protected const IS_EMPTY_TYPES_VALIDATION_ENABLED = true;
}
