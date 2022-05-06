<?php

use ESpirit\Shared\FirstSpiritCaaS\FirstSpiritCaaSConstants;
use ESpirit\Shared\FirstSpiritDataImport\FirstSpiritDataImportConstants;

$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_DATABASE_PREVIEW] = 'SprykerUpdate@preview';
$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_DATABASE_ONLINE] = 'SprykerUpdate';

$config[FirstSpiritDataImportConstants::FIRSTSPIRIT_DATA_IMPORT_URL_TEMPLATE] = '/{locale}/{url}';
