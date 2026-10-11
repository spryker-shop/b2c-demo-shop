<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Glue\StoresRestApi;

use Pyz\Glue\StoresRestApi\Processor\Stores\StoresReader;
use Spryker\Glue\StoresRestApi\Processor\Stores\StoresReaderInterface;
use Spryker\Glue\StoresRestApi\StoresRestApiFactory as SprykerStoresRestApiFactory;

class StoresRestApiFactory extends SprykerStoresRestApiFactory
{
    public function createStoresReader(): StoresReaderInterface
    {
        return new StoresReader(
            $this->createStoresCountryReader(),
            $this->createStoresCurrencyReader(),
            $this->getResourceBuilder(),
            $this->createStoresResourceMapper(),
            $this->getStoreClient(),
            $this->getStoreStorageClient(),
        );
    }
}
