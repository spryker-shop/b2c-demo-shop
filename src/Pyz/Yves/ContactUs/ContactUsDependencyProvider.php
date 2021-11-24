<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContactUs;

use Spryker\Client\Kernel\Container;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;

class ContactUsDependencyProvider extends AbstractBundleDependencyProvider
{
    public function provideServiceLayerDependencies(Container $container)
    {
        return $container;
    }
}
