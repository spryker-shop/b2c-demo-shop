<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductStorage\Communication\Plugin\Event\Subscriber;

use Pyz\Zed\ProductBundle\Dependency\ProductBundleEvents;
use Pyz\Zed\ProductStorage\Communication\Plugin\Event\Listener\ProductBundleStoragePublishListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\ProductStorage\Communication\Plugin\Event\Subscriber\ProductStorageEventSubscriber as SprykerProductStorageEventSubscriber;

class ProductStorageEventSubscriber extends SprykerProductStorageEventSubscriber
{
    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection = parent::getSubscribedEvents($eventCollection);
        $eventCollection = $this->addProductBundleCreateStorageListener($eventCollection);
        $eventCollection = $this->addProductBundleUpdateStorageListener($eventCollection);
        $eventCollection = $this->addProductBundleDeleteStorageListener($eventCollection);

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addProductBundleCreateStorageListener(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(
            ProductBundleEvents::ENTITY_SPY_PRODUCT_BUNDLE_CREATE,
            new ProductBundleStoragePublishListener()
        );

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addProductBundleUpdateStorageListener(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(
            ProductBundleEvents::ENTITY_SPY_PRODUCT_BUNDLE_UPDATE,
            new ProductBundleStoragePublishListener()
        );

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addProductBundleDeleteStorageListener(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(
            ProductBundleEvents::ENTITY_SPY_PRODUCT_BUNDLE_DELETE,
            new ProductBundleStoragePublishListener()
        );

        return $eventCollection;
    }
}
