<?php

namespace Pyz\Zed\Book;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Communication\Form\FormFactory;

class BookDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FORM_FACTORY = 'FORM_FACTORY';

    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container[static::FORM_FACTORY] = function (Container $container) {
            return new FormFactory();
        };

        return $container;
    }
}
