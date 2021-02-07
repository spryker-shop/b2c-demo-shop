<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\HelloSpryker\Plugin\Provider;

use Silex\Application;
use SprykerShop\Yves\ShopApplication\Plugin\Provider\AbstractYvesControllerProvider;

class HelloSprykerControllerProvider extends AbstractYvesControllerProvider
{
    public const HELLOSPRYKER_INDEX = 'hellospryker-index';

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function defineControllers(Application $app)
    {
        $this->createGetController('/hello-spryker', static::HELLOSPRYKER_INDEX, 'HelloSpryker', 'Index', 'index');
    }
}
