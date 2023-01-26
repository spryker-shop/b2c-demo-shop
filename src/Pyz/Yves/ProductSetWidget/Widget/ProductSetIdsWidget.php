<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductSetWidget\Widget;

use Generated\Shared\Transfer\ProductSetDataStorageTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidget;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Yves\ProductSetWidget\ProductSetWidgetFactory getFactory()
 */
class ProductSetIdsWidget extends AbstractWidget
{
    /**
     * @var string
     */
    public const PYZ_NAME = 'ProductSetIdsWidget';

    /**
     * @var string
     */
    public const PYZ_PARAM_ATTRIBUTE = 'attributes';

    /**
     * @var string
     */
    protected const PYZ_PARAMETER_PRODUCT_SET_LIST = 'productSetList';

    /**
     * @param array $productSetIds
     */
    public function __construct(array $productSetIds)
    {
        $this->addPyzProductSetListParameter($productSetIds);
    }

    /**
     * @param array $productSetIds
     *
     * @return void
     */
    protected function addPyzProductSetListParameter(array $productSetIds): void
    {
        $productSetList = $this->getPyzProductSetList($productSetIds);

        $this->addParameter(self::PYZ_PARAMETER_PRODUCT_SET_LIST, $productSetList);
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return static::PYZ_NAME;
    }

    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return '@ProductSetWidget/views/product-set-ids/product-set-ids.twig';
    }

    /**
     * @param array<int> $productSetIds
     *
     * @return array
     */
    protected function getPyzProductSetList(array $productSetIds): array
    {
        $productSets = [];
        foreach ($productSetIds as $productSetId) {
            $productSet = $this->getPyzSingleProductSet($productSetId);
            if (!isset($productSet['productSet'])) {
                continue;
            }

            $productSets[] = $productSet;
        }

        return $productSets;
    }

    /**
     * @param int $productSetId
     *
     * @return array
     */
    protected function getPyzSingleProductSet(int $productSetId): array
    {
        $productSet = $this->getPyzProductSetDataStorageTransfer($productSetId);

        if (!$productSet || !$productSet->getIsActive()) {
            return [];
        }

        return [
            'productSet' => $productSet,
            'productViews' => $this->mapPyzProductViewTransfers($productSet),
        ];
    }

    /**
     * @param int $idProductSet
     *
     * @return \Generated\Shared\Transfer\ProductSetDataStorageTransfer|null
     */
    protected function getPyzProductSetDataStorageTransfer(int $idProductSet): ?ProductSetDataStorageTransfer
    {
        return $this->getFactory()->getPyzProductSetStorageClient()->getProductSetByIdProductSet($idProductSet, $this->getLocale());
    }

    /**
     * @param \Generated\Shared\Transfer\ProductSetDataStorageTransfer $productSetDataStorageTransfer
     *
     * @return array<\Generated\Shared\Transfer\ProductViewTransfer>
     */
    protected function mapPyzProductViewTransfers(ProductSetDataStorageTransfer $productSetDataStorageTransfer): array
    {
        $productViewTransfers = [];

        foreach ($productSetDataStorageTransfer->getProductAbstractIds() as $idProductAbstract) {
            $productViewTransfer = $this->getFactory()->getPyzProductStorageClient()->findProductAbstractViewTransfer(
                $idProductAbstract,
                $this->getLocale(),
                $this->getPyzSelectedAttributes($idProductAbstract),
            );

            if ($productViewTransfer === null) {
                continue;
            }

            $productViewTransfers[] = $productViewTransfer;
        }

        return $productViewTransfers;
    }

    /**
     * @param int $idProductAbstract
     *
     * @return array
     */
    protected function getPyzSelectedAttributes(int $idProductAbstract): array
    {
        $attributes = $this->getPyzRequest()->query->get(static::PYZ_PARAM_ATTRIBUTE, null) ?? [];

        return isset($attributes[$idProductAbstract]) ? array_filter((array)$attributes[$idProductAbstract]) : [];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function getPyzRequest(): Request
    {
        return $this->getApplication()['request'];
    }
}
