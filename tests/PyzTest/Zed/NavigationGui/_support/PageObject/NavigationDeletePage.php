<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\NavigationGui\PageObject;

class NavigationDeletePage
{
    /**
     * @var string
     */
    public const URL = '/navigation-gui/delete?id-navigation=%d';

    /**
     * @var string
     */
    public const MESSAGE_SUCCESS = '/Navigation element (\d+) was deleted successfully\\./';
}
