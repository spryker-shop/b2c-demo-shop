<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Shared\Testify\Helper;

use Codeception\Exception\ModuleConfigException;
use Codeception\Lib\Framework;
use Pyz\Yves\ShopApplication\YvesBootstrap as PyzYvesBootstrap;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Client;

class YvesBootstrap extends Framework
{
    /**
     * @var \Pyz\Yves\ShopApplication\YvesBootstrap
     */
    private $yvesBootstrap;

    /**
     * @return void
     */
    public function _initialize()
    {
        $this->loadApplication();
    }

    /**
     * @param array $settings
     *
     * @return void
     */
    public function _beforeSuite($settings = [])
    {
        $this->client = new Client($this->yvesBootstrap->boot());
    }

    /**
     * @throws \Codeception\Exception\ModuleConfigException
     *
     * @return void
     */
    protected function loadApplication()
    {
        $this->yvesBootstrap = new PyzYvesBootstrap();

        $requestFactory = function (array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null) {
            $request = new Request($query, $request, $attributes, $cookies, $files, $server, $content);
            $request->server->set('SERVER_NAME', 'localhost');

            return $request;
        };
        Request::setFactory($requestFactory);

        if (!isset($this->yvesBootstrap)) {
            throw new ModuleConfigException(self::class, 'Application instance was not received from bootstrap file');
        }
    }
}
