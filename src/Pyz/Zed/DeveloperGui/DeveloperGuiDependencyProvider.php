<?php

namespace Pyz\Zed\DeveloperGui;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class DeveloperGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const QUERY_CONTAINER_DEVELOPER = 'QUERY_CONTAINER_DEVELOPER';
    public const FACADE_DEVELOPER = 'FACADE_DEVELOPER';
    public const FACADE_GLOSSARY = 'CLIENT_GLOSSARY';
    public const CLIENT_LOCALE = 'CLIENT_LOCALE';

    /**
     * @param Container $container
     *
     * @return Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = $this->addDeveloperQueryContainer($container);
        $container = $this->addDeveloperFacade($container);
        $container = $this->addGlossaryFacade($container);

        return $container;
    }

    /**
     * @param Container $container
     *
     * @return Container
     */
    protected function addDeveloperFacade(Container $container): Container
    {
        $container->set(static::FACADE_DEVELOPER, function (Container $container) {
            return $container->getLocator()->developer()->facade();
        });

        return $container;
    }

    /**
     * @param Container $container
     *
     * @return Container
     */
    protected function addGlossaryFacade(Container $container): Container
    {
        $container->set(static::FACADE_GLOSSARY, function (Container $container) {
            return $container->getLocator()->glossary()->facade();
        });

        return $container;
    }

    /**
     * @param Container $container
     *
     * @return Container
     */
    protected function addDeveloperQueryContainer(Container $container): Container
    {
        $container->set(static::QUERY_CONTAINER_DEVELOPER, function (Container $container) {
            return $container->getLocator()->developer()->queryContainer();
        });

        return $container;
    }

}
