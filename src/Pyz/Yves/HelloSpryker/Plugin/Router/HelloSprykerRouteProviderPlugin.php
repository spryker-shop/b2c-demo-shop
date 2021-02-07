<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\HelloSpryker\Plugin\Router;

use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;

class HelloSprykerRouteProviderPlugin extends AbstractRouteProviderPlugin
{
    public const ROUTE_NAME_HELLO_SPRYKER_INDEX = 'hello-spryker-index';

    /**
     * Specification:
     * - Adds Routes to the RouteCollection.
     *
     * @api
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/hello-spryker', 'HelloSpryker', 'Index', 'index');
        $routeCollection->add(static::ROUTE_NAME_HELLO_SPRYKER_INDEX, $route);

        return $routeCollection;
    }
}
