<?php


/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class BookConfig extends AbstractBundleConfig
{
    /**
     * Used as `item_type` for touch mechanism.
     *
     * @var string
     */
    public const RESOURCE_TYPE_BOOK = 'book';

    /**
     * @var string
     */
    protected const REDIRECT_URL_DEFAULT = '/book';

    /**
     * @return array<string>
     * @api
     *
     */
    public function getBookFilePaths(): array
    {
        /** @var array<string> $sourceBooks */
        $sourceBooks = glob(APPLICATION_SOURCE_DIR . '/*/*/*/Resources/book.yml', GLOB_NOSORT);

        /** @var array<string> $vendorBooks */
        $vendorBooks = glob(APPLICATION_VENDOR_DIR . '/*/*/src/*/*/*/Resources/book.yml', GLOB_NOSORT);

        $paths = array_merge(
            $sourceBooks,
            $vendorBooks,
        );

        return $paths;
    }

    /**
     * @return string
     * @api
     *
     */
    public function getDefaultRedirectUrl(): string
    {
        return static::REDIRECT_URL_DEFAULT;
    }
}
