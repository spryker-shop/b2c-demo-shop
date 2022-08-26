<?php

namespace Pyz\Client\Faq;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class FaqDependencyProvider extends AbstractDependencyProvider {

    public const CLIENT_ZED_REQUEST = 'FAQ_CLIENT_ZED_REQUEST';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = $this->addZedRequestClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addZedRequestClient(Container $container): Container
    {
        $container->set(static::CLIENT_ZED_REQUEST,
            function (Container $container) {
                return $container->getLocator()->zedRequest()->client();
            }
        );

        return $container;
    }
}
