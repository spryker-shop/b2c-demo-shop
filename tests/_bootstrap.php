<?php

if (getenv('SPRYKER_TESTING_ENABLED')) {
    define('APPLICATION_ENV', getenv('APPLICATION_ENV'));
}

define('APPLICATION_ROOT_DIR', dirname(__DIR__));

putenv('APPLICATION_STORE=DE');
