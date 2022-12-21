<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Console\Helper;

use Codeception\Module;
use Codeception\TestInterface;
use Codeception\Util\FileSystem;
use SprykerTest\Shared\Testify\Helper\ModuleHelperConfigTrait;

class ConsoleHelper extends Module
{
    use ModuleHelperConfigTrait;

    /**
     * @var string
     */
    public const RUNNER = 'console_runner.php';

    /**
     * @var string
     */
    public const SANDBOX_DIR = 'cli_sandbox/';

    /**
     * @param \Codeception\TestInterface $test
     *
     * @return void
     */
    public function _after(TestInterface $test): void
    {
        foreach ($this->config['cleanup_dirs'] as $dir) {
            $dir = codecept_data_dir() . self::SANDBOX_DIR . $dir;
            $this->debugSection('Cleanup', $dir);
            FileSystem::deleteDir($dir);
        }
    }

    /**
     * @param string $command
     *
     * @return void
     */
    public function runSprykerCommand($command): void
    {
        $command = 'php ' . codecept_data_dir() . self::RUNNER . " $command";
        $this->getCli()->runShellCommand($command);
    }

    /**
     * @return void
     */
    protected function setDefaultConfig(): void
    {
        $this->config = [
            'cleanup_dirs' => ['data', 'src'],
        ];
    }

    /**
     * @return \Codeception\Module\Cli|\Codeception\Module
     */
    protected function getCli()
    {
        return $this->getModule('Cli');
    }
}
