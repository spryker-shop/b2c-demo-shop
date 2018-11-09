<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductSearchAttribute\Hook;

use Spryker\Zed\DataImport\Business\Model\DataImporterAfterImportInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher;
use Spryker\Zed\ProductSearch\Dependency\ProductSearchEvents;

class ProductSearchAfterImportHook implements DataImporterAfterImportInterface
{
    public const ID_DEFAULT = 0;

    /**
     * @return void
     */
    public function afterImport()
    {
        DataImporterPublisher::addImportedEntityEvents([
            ProductSearchEvents::PRODUCT_SEARCH_CONFIG_PUBLISH => [
                static::ID_DEFAULT,
            ],
        ]);
    }
}
