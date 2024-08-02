<?php

namespace Pyz\Client\Catalog\Plugin\ConfigTransferBuilder;

use Generated\Shared\Search\PageIndexMap;
use Generated\Shared\Transfer\SortConfigTransfer;
use Spryker\Client\Catalog\Dependency\Plugin\SortConfigTransferBuilderPluginInterface;
use Spryker\Client\Kernel\AbstractPlugin;

class AscendingCarbonEmissionSortConfigTransferBuilderPlugin extends AbstractPlugin implements SortConfigTransferBuilderPluginInterface
{
    /**
     * @var string
     */
    public const NAME = 'carbon_emission';

    /**
     * @var string
     */
    public const PARAMETER_NAME = 'carbon_emission_asc';

    /**
     * @return \Generated\Shared\Transfer\SortConfigTransfer
     */
    public function build()
    {
        return (new SortConfigTransfer())
            ->setName(static::NAME)
            ->setParameterName(static::PARAMETER_NAME)
            ->setFieldName(PageIndexMap::INTEGER_SORT);
    }
}
