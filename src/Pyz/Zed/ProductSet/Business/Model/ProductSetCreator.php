<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductSet\Business\Model;

use Generated\Shared\Transfer\EventEntityTransfer;
use Generated\Shared\Transfer\ProductSetTransfer;
use Orm\Zed\ProductSet\Persistence\SpyProductAbstractSet;
use Orm\Zed\ProductSet\Persistence\SpyProductSet;
use Spryker\Zed\Event\Business\EventFacadeInterface;
use Spryker\Zed\Product\Dependency\ProductEvents;
use Spryker\Zed\ProductSet\Business\Model\Data\ProductSetDataCreatorInterface;
use Spryker\Zed\ProductSet\Business\Model\Image\ProductSetImageSaverInterface;
use Spryker\Zed\ProductSet\Business\Model\ProductSetCreator as SprykerProductSetCreator;
use Spryker\Zed\ProductSet\Business\Model\Touch\ProductSetTouchInterface;
use Spryker\Zed\PropelOrm\Business\Transaction\DatabaseTransactionHandlerTrait;

class ProductSetCreator extends SprykerProductSetCreator
{
    use DatabaseTransactionHandlerTrait;

    /**
     * @var \Spryker\Zed\ProductSet\Business\Model\Data\ProductSetDataCreatorInterface
     */
    protected $productSetDataCreator;

    /**
     * @var \Spryker\Zed\ProductSet\Business\Model\Touch\ProductSetTouchInterface
     */
    protected $productSetTouch;

    /**
     * @var \Spryker\Zed\ProductSet\Business\Model\Image\ProductSetImageSaverInterface
     */
    protected $productSetImageSaver;

    /**
     * @var \Spryker\Zed\Event\Business\EventFacadeInterface
     */
    protected $eventFacade;

    /**
     * @param \Spryker\Zed\ProductSet\Business\Model\Data\ProductSetDataCreatorInterface $productSetDataCreator
     * @param \Spryker\Zed\ProductSet\Business\Model\Touch\ProductSetTouchInterface $productSetTouch
     * @param \Spryker\Zed\ProductSet\Business\Model\Image\ProductSetImageSaverInterface $productSetImageSaver
     * @param \Spryker\Zed\Event\Business\EventFacadeInterface $eventFacade
     */
    public function __construct(
        ProductSetDataCreatorInterface $productSetDataCreator,
        ProductSetTouchInterface $productSetTouch,
        ProductSetImageSaverInterface $productSetImageSaver,
        EventFacadeInterface $eventFacade
    ) {
        $this->productSetTouch = $productSetTouch;
        $this->productSetDataCreator = $productSetDataCreator;
        $this->productSetImageSaver = $productSetImageSaver;
        $this->eventFacade = $eventFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductSetTransfer $productSetTransfer
     *
     * @return \Generated\Shared\Transfer\ProductSetTransfer
     */
    public function createProductSet(ProductSetTransfer $productSetTransfer)
    {
        return $this->handleDatabaseTransaction(function () use ($productSetTransfer) {
            return $this->executeCreateProductSetTransaction($productSetTransfer);
        });
    }

    /**
     * @param \Generated\Shared\Transfer\ProductSetTransfer $productSetTransfer
     *
     * @return \Generated\Shared\Transfer\ProductSetTransfer
     */
    protected function executeCreateProductSetTransaction(ProductSetTransfer $productSetTransfer)
    {
        $productSetEntity = $this->createProductSetEntity($productSetTransfer);

        $idProductSet = $productSetEntity->getIdProductSet();
        $productSetTransfer->setIdProductSet($idProductSet);

        $productSetTransfer = $this->productSetDataCreator->createProductSetData($productSetTransfer);
        $productSetTransfer = $this->productSetImageSaver->saveImageSets($productSetTransfer);

        $this->touchProductSet($productSetTransfer);

        if (!$productSetEntity->getSpyProductAbstractSets()->isEmpty()) {
            foreach ($productSetEntity->getSpyProductAbstractSets() as $productAbstractSets) {
                $this->eventFacade->trigger(ProductEvents::PRODUCT_ABSTRACT_PUBLISH, (new EventEntityTransfer())->setId($productAbstractSets->getFkProductAbstract()));
            }
        }

        return $productSetTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductSetTransfer $productSetTransfer
     *
     * @return \Orm\Zed\ProductSet\Persistence\SpyProductSet
     */
    protected function createProductSetEntity(ProductSetTransfer $productSetTransfer)
    {
        $productSetEntity = new SpyProductSet();
        $productSetEntity->fromArray($productSetTransfer->modifiedToArray());

        $idProductAbstracts = array_values($productSetTransfer->getIdProductAbstracts());
        foreach ($idProductAbstracts as $index => $idProductAbstract) {
            $position = $index + 1;
            $productAbstractSetEntity = $this->createProductAbstractSetEntity($idProductAbstract, $position);
            $productSetEntity->addSpyProductAbstractSet($productAbstractSetEntity);
        }

        $productSetEntity->save();

        return $productSetEntity;
    }

    /**
     * @param int $idProductAbstract
     * @param int $position
     *
     * @return \Orm\Zed\ProductSet\Persistence\SpyProductAbstractSet
     */
    protected function createProductAbstractSetEntity($idProductAbstract, $position)
    {
        $productAbstractSetEntity = new SpyProductAbstractSet();
        $productAbstractSetEntity
            ->setFkProductAbstract($idProductAbstract)
            ->setPosition($position);

        return $productAbstractSetEntity;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductSetTransfer $productSetTransfer
     *
     * @return void
     */
    protected function touchProductSet(ProductSetTransfer $productSetTransfer)
    {
        $this->productSetTouch->touchProductSetByStatus($productSetTransfer);
    }
}
