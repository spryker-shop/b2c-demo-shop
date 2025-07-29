<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

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
    public const NAME = 'ProductSetIdsWidget';

    /**
     * @var string
     */
    public const PARAM_ATTRIBUTE = 'attributes';

    /**
     * @var string
     */
    protected const PARAMETER_PRODUCT_SET_LIST = 'productSetList';

    /**
     * @param list<int> $productSetIds
     */
    public function __construct(array $productSetIds)
    {
        $this->addProductSetListParameter($productSetIds);
    }

    /**
     * @param list<int> $productSetIds
     *
     * @return void
     */
    protected function addProductSetListParameter(array $productSetIds): void
    {
        $productSetList = $this->getProductSetList($productSetIds);

        $this->addParameter(self::PARAMETER_PRODUCT_SET_LIST, $productSetList);
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return static::NAME;
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
     * @return array<mixed>
     */
    protected function getProductSetList(array $productSetIds): array
    {
        $productSets = [];
        foreach ($productSetIds as $productSetId) {
            $productSet = $this->getSingleProductSet($productSetId);
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
     * @return array<string, mixed>
     */
    protected function getSingleProductSet(int $productSetId): array
    {
        $productSet = $this->getProductSetDataStorageTransfer($productSetId);

        if (!$productSet || !$productSet->getIsActive()) {
            return [];
        }

        return [
            'productSet' => $productSet,
            'productViews' => $this->mapProductViewTransfers($productSet),
        ];
    }

    /**
     * @param int $idProductSet
     *
     * @return \Generated\Shared\Transfer\ProductSetDataStorageTransfer|null
     */
    protected function getProductSetDataStorageTransfer(int $idProductSet): ?ProductSetDataStorageTransfer
    {
        return $this->getFactory()->getProductSetStorageClient()->getProductSetByIdProductSet($idProductSet, $this->getLocale());
    }

    /**
     * @param \Generated\Shared\Transfer\ProductSetDataStorageTransfer $productSetDataStorageTransfer
     *
     * @return array<\Generated\Shared\Transfer\ProductViewTransfer>
     */
    protected function mapProductViewTransfers(ProductSetDataStorageTransfer $productSetDataStorageTransfer): array
    {
        $productViewTransfers = [];

        foreach ($productSetDataStorageTransfer->getProductAbstractIds() as $idProductAbstract) {
            $productViewTransfer = $this->getFactory()->getProductStorageClient()->findProductAbstractViewTransfer(
                $idProductAbstract,
                $this->getLocale(),
                $this->getSelectedAttributes($idProductAbstract),
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
     * @return array<mixed>
     */
    protected function getSelectedAttributes(int $idProductAbstract): array
    {
        $attributes = $this->getRequest()->query->get(static::PARAM_ATTRIBUTE, null) ?? [];

        return isset($attributes[$idProductAbstract]) ? array_filter((array)$attributes[$idProductAbstract]) : [];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function getRequest(): Request
    {
        return $this->getApplication()['request'];
    }
}
