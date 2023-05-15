<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Shared\Testify\Helper;

use Codeception\Module;
use Spryker\Shared\Kernel\CodeBucket\Config\CodeBucketConfig;
use Spryker\Shared\Kernel\CodeBucket\Config\CodeBucketConfigInterface;

class Environment extends Module
{
    /**
     * @var string
     */
    protected const TESTING_APPLICATION_ENV_NAME = 'devtest';

    /**
     * @return void
     */
    public function _initialize(): void
    {
        $rootDir = realpath(__DIR__ . '/../../../../../../');
        $applicationEnv = $this->getApplicationEnv();

        defined('APPLICATION_ENV') || define('APPLICATION_ENV', $applicationEnv);
        defined('APPLICATION_STORE') || define('APPLICATION_STORE', (isset($_SERVER['APPLICATION_STORE']) && $_SERVER['APPLICATION_STORE'] !== '') ? $_SERVER['APPLICATION_STORE'] : 'DE');
        putenv('APPLICATION_STORE=' . APPLICATION_STORE);

        defined('APPLICATION') || define('APPLICATION', '');

        defined('APPLICATION_ROOT_DIR') || define('APPLICATION_ROOT_DIR', $rootDir);
        defined('APPLICATION_SOURCE_DIR') || define('APPLICATION_SOURCE_DIR', APPLICATION_ROOT_DIR . '/src');
        defined('APPLICATION_VENDOR_DIR') || define('APPLICATION_VENDOR_DIR', APPLICATION_ROOT_DIR . '/vendor');

        defined('APPLICATION_CODE_BUCKET') || define('APPLICATION_CODE_BUCKET', $this->createCodeBucketConfig()->getCurrentCodeBucket());
        putenv('APPLICATION_CODE_BUCKET=' . APPLICATION_CODE_BUCKET);
    }

    /**
     * @return string
     */
    protected function getApplicationEnv(): string
    {
        if (getenv('SPRYKER_TESTING_ENABLED')) {
            return getenv('APPLICATION_ENV');
        }

        return static::TESTING_APPLICATION_ENV_NAME;
    }

    /**
     * @return \Spryker\Shared\Kernel\CodeBucket\Config\CodeBucketConfigInterface
     */
    protected function createCodeBucketConfig(): CodeBucketConfigInterface
    {
        return new CodeBucketConfig();
    }
}
