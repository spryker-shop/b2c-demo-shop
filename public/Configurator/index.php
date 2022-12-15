<?php

use SprykerShop\Configurator\DateTimeConfiguratorPageExample\ConfiguratorPage;
use Symfony\Component\HttpFoundation\Response;

define('APPLICATION', 'CONFIGURATOR');
defined('APPLICATION_ROOT_DIR') || define('APPLICATION_ROOT_DIR', dirname(__DIR__, 2));

require_once APPLICATION_ROOT_DIR . '/vendor/autoload.php';

$configuratorPage = new ConfiguratorPage();

$response = $configuratorPage->render();

if ($response instanceof Response) {
    $response->send();
}

echo $response;
