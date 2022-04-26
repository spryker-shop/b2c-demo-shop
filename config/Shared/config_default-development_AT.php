<?php

use ESpirit\Shared\FirstSpiritCaaS\FirstSpiritCaaSConstants;
use Spryker\Shared\Propel\PropelConstants;

$config[PropelConstants::ZED_DB_DATABASE] = 'DE_development_zed';

// ----------- FirstSpirit CaaS Configurations
$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_DATABASE_PREVIEW] = 'SprykerUpdate@preview';
$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_DATABASE_ONLINE] = 'SprykerUpdate';
