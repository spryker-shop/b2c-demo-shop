<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductLabel\Hook;

use Spryker\Zed\DataImport\Business\Model\DataImporterAfterImportInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher;
use Spryker\Zed\ProductLabel\Dependency\ProductLabelEvents;

class ProductLabelAfterImportPublishHook implements DataImporterAfterImportInterface
{
    const ID_DEFAULT = 0;

    /**
     * @return void
     */
    public function afterImport()
    {
        DataImporterPublisher::addImportedEntityEvents([
            ProductLabelEvents::PRODUCT_LABEL_DICTIONARY_PUBLISH => [
                static::ID_DEFAULT,
            ],
        ]);
    }
}
