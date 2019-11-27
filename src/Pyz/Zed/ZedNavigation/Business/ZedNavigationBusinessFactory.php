<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ZedNavigation\Business;

use Pyz\Zed\ZedNavigation\Business\Model\Formatter\MenuFormatter;
use Spryker\Zed\ZedNavigation\Business\ZedNavigationBusinessFactory as SprykerZedNavigationBusinessFactory;

class ZedNavigationBusinessFactory extends SprykerZedNavigationBusinessFactory
{
    /**
     * @return \Spryker\Zed\ZedNavigation\Business\Model\Formatter\MenuFormatter
     */
    protected function createMenuFormatter()
    {
        $urlBuilder = $this->getUrlBuilder();
        $urlUniqueValidator = $this->createUrlUniqueValidator();
        $menuLevelValidator = $this->createMenuLevelValidator();

        return new MenuFormatter(
            $urlUniqueValidator,
            $menuLevelValidator,
            $urlBuilder
        );
    }
}
