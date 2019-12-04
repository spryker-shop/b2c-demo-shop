<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\PaymentDataImport;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Spryker\Zed\PaymentDataImport\PaymentDataImportConfig as SprykerPaymentDataImportConfig;

class PaymentDataImportConfig extends SprykerPaymentDataImportConfig
{
    /**
     * @return \Generated\Shared\Transfer\DataImporterConfigurationTransfer
     */
    public function getPaymentMethodDataImporterConfiguration(): DataImporterConfigurationTransfer
    {
        return $this->buildImporterConfiguration('payment_method.csv', static::IMPORT_TYPE_PAYMENT_METHOD);
    }

    /**
     * @return \Generated\Shared\Transfer\DataImporterConfigurationTransfer
     */
    public function getPaymentMethodStoreDataImporterConfiguration(): DataImporterConfigurationTransfer
    {
        return $this->buildImporterConfiguration('payment_method_store.csv', static::IMPORT_TYPE_PAYMENT_METHOD_STORE);
    }
}
