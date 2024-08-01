<?php

namespace Pyz\Zed\SearchElasticsearch\Communication\Plugin\ProductPageSearch\Elasticsearch;

use Exception;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductAbstractMapExpanderPluginInterface;

class PyzProductCarbonEmissionSortMapExpanderPlugin  extends AbstractPlugin implements ProductAbstractMapExpanderPluginInterface
{
    use LoggerTrait;

    /**
     * @var string
     */
    protected const MAX_INT_VALUE_IN_STRING = '214748364';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface $pageMapBuilder
     * @param array $productData
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function expandProductMap(
        PageMapTransfer $pageMapTransfer,
        PageMapBuilderInterface $pageMapBuilder,
        array $productData,
        LocaleTransfer $localeTransfer,
    ) {
        try {
            if (isset($productData['attributes']['carbon_emission'])) {
                $pageMapBuilder->addStringFacet(
                    $pageMapTransfer,
                    'carbon_emission',
                    $productData['attributes']['carbon_emission'],
                );
                $pageMapBuilder->addStringSort(
                    $pageMapTransfer,
                    $this->buildSortFieldName(),
                    $productData['attributes']['carbon_emission'],
                );

                $pageMapBuilder->addSearchResultData(
                    $pageMapTransfer,
                    $this->buildSortFieldName(),
                    $productData['attributes']['carbon_emission'],
                );
            }
        } catch (Exception $th) {
            $this->getLogger()->error($th->getMessage());
        }

        return $pageMapTransfer;
    }

    protected static function buildSortFieldName(): string
    {
        return sprintf(
            '%s',
            'carbon_emission'
        );
    }
}
