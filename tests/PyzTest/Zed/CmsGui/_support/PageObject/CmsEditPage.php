<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\CmsGui\PageObject;

class CmsEditPage
{
    /**
     * @var string
     */
    public const URL = 'cms-gui/edit-page?id-cms-page=%d';

    /**
     * @var string
     */
    public const PAGE_ACTIVATE_SUCCESS_MESSAGE = 'Page was created successfully.';

    /**
     * @var string
     */
    public const PAGE_PUBLISH_SUCCESS_MESSAGE = 'Page with version 1 successfully published.';
}
