<?php

use ESpirit\Shared\FirstSpiritCaaS\FirstSpiritCaaSConstants;
use ESpirit\Shared\FirstSpiritDataImport\FirstSpiritDataImportConstants;

$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_DATABASE_PREVIEW] = 'SprykerUpdateAT@preview';
$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_DATABASE_ONLINE] = 'SprykerUpdateAT';

$config[FirstSpiritDataImportConstants::FIRSTSPIRIT_DATA_IMPORT_URL_TEMPLATE] = '/{locale}/{store}/content-pages/{url}';
