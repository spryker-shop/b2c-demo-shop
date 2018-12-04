<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductSet\Business\Model;

use Generated\Shared\Transfer\EventEntityTransfer;
use Generated\Shared\Transfer\ProductSetTransfer;
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
        parent::__construct($productSetDataCreator, $productSetTouch, $productSetImageSaver);

        $this->eventFacade = $eventFacade;
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
}
