<?php

namespace Pyz\Yves\ContactUs\Plugin\Router;

use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;

class ContactUsRouteProviderPlugin extends AbstractRouteProviderPlugin
{
    protected const ROUTE_CONTACT_US_INDEX = 'contact-us-index';

    /**
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addContactUsIndexRoute($routeCollection);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addContactUsIndexRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/contact-us', 'ContactUs', 'Index', 'indexAction');
        $route = $route->setMethods(['GET', 'POST']);
        $routeCollection->add(static::ROUTE_CONTACT_US_INDEX, $route);

        return $routeCollection;
    }
}
