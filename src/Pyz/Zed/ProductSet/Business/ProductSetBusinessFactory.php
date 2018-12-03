<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductSet\Business;

use Pyz\Zed\ProductSet\Business\Model\ProductSetCreator;
use Pyz\Zed\ProductSet\Business\Model\ProductSetUpdater;
use Pyz\Zed\ProductSet\ProductSetDependencyProvider;
use Spryker\Zed\ProductSet\Business\ProductSetBusinessFactory as SprykerProductSetBusinessFactory;

/**
 * @method \Spryker\Zed\ProductSet\ProductSetConfig getConfig()
 * @method \Spryker\Zed\ProductSet\Persistence\ProductSetQueryContainerInterface getQueryContainer()
 */
class ProductSetBusinessFactory extends SprykerProductSetBusinessFactory
{
    /**
     * @return \Spryker\Zed\ProductSet\Business\Model\ProductSetCreatorInterface
     */
    public function createProductSetCreator()
    {
        return new ProductSetCreator(
            $this->createProductSetDataCreator(),
            $this->createProductSetTouch(),
            $this->createProductSetImageCreator(),
            $this->getEventFacade()
        );
    }

    /**
     * @return \Spryker\Zed\ProductSet\Business\Model\ProductSetUpdaterInterface
     */
    public function createProductSetUpdater()
    {
        return new ProductSetUpdater(
            $this->createProductSetEntityReader(),
            $this->createProductSetDataUpdater(),
            $this->createProductSetImageCreator(),
            $this->createProductSetTouch(),
            $this->getEventFacade()
        );
    }

    /**
     * @deprecated Please make sure that your `getEventFacade()` method is public. With the next major we will use public methods only in this factory.
     *
     * @return \Spryker\Zed\Event\Business\EventFacadeInterface
     */
    protected function getEventFacade()
    {
        return $this->getProvidedDependency(ProductSetDependencyProvider::FACADE_EVENT);
    }
}
