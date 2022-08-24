<?php

namespace Pyz\Zed\Faq;

use Orm\Zed\Planet\Persistence\PyzFaqQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class FaqDependencyProvider extends AbstractBundleDependencyProvider {

    public const QUERY_FAQ = 'QUERY_FAQ';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     * @throws \Spryker\Service\Container\Exception\ContainerException
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException
     */
    public function provideCommunicationLayerDependencies(Container $container): Container {

        $container = $this->addPyzFaqQuery($container);

        return $container;
    }


    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     * @throws \Spryker\Service\Container\Exception\ContainerException
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException
     */
    private function addPyzFaqQuery(Container $container): Container {

        $container->set(
            static::QUERY_FAQ,
            $container->factory(
                fn() => PyzFaqQuery::create()
            )
        );

        return $container;
    }
}
