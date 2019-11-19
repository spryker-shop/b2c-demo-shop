<?php

namespace Pyz\Zed\ShipmentDataImport;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Spryker\Zed\ShipmentDataImport\ShipmentDataImportConfig as SprykerShipmentDataImportConfig;

class ShipmentDataImportConfig extends SprykerShipmentDataImportConfig
{
    /**
     * @return \Generated\Shared\Transfer\DataImporterConfigurationTransfer
     */
    public function getShipmentDataImporterConfiguration(): DataImporterConfigurationTransfer
    {
        return $this->buildImporterConfiguration('shipment.csv', static::IMPORT_TYPE_SHIPMENT);
    }

    /**
     * @return \Generated\Shared\Transfer\DataImporterConfigurationTransfer
     */
    public function getShipmentMethodPriceDataImporterConfiguration(): DataImporterConfigurationTransfer
    {
        return $this->buildImporterConfiguration('shipment_price.csv', static::IMPORT_TYPE_SHIPMENT_PRICE);
    }
}
