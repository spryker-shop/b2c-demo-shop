<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Propel\Communication\Plugin\Application;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Zed\Propel\Communication\Plugin\Application\PropelApplicationPlugin as SprykerPropelApplicationPlugin;

class PropelApplicationPlugin extends SprykerPropelApplicationPlugin
{
    protected const ADAPTER_CLASS_PATTERN = 'Pyz\Zed\Propel\Adapter\Pdo\%sAdapter';

    /**
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Service\Container\ContainerInterface
     */
    public function provide(ContainerInterface $container): ContainerInterface
    {
        $container = parent::provide($container);

        $this->getServiceContainer()->setAdapterClass(
            static::DATA_SOURCE_NAME,
            $this->getAdapterClass()
        );

        return $container;
    }

    /**
     * @return string
     */
    protected function getAdapterClass(): string
    {
        return sprintf(static::ADAPTER_CLASS_PATTERN, ucfirst($this->getConfig()->getCurrentDatabaseEngine()));
    }
}
