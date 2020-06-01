<?php

/**
 * This is the global runtime configuration for Yves and Generated_Yves_Zed in a staging environment.
 */

use Spryker\Shared\Application\ApplicationConstants;
use SprykerShop\Shared\ShopApplication\ShopApplicationConstants;

// ---------- General
$config[ApplicationConstants::ENABLE_APPLICATION_DEBUG]
    = $config[ShopApplicationConstants::ENABLE_APPLICATION_DEBUG]
    = true;
