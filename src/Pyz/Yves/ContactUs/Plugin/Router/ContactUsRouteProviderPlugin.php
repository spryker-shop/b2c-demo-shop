<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContactUs\Plugin\Router;

use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;

class ContactUsRouteProviderPlugin extends AbstractRouteProviderPlugin
{
    public const CONTACT_US_INDEX = 'contact-us-index';

    /**
     * @inheritDoc
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addContactIndexRoute($routeCollection);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    private function addContactIndexRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/contact-us', 'ContactUs', 'Index', 'indexAction');
        $route = $route->setMethods(['GET', 'POST']);
        $routeCollection->add(static::CONTACT_US_INDEX, $route);

        return $routeCollection;
    }
}
