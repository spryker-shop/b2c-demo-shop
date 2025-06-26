<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace SprykerConfig;

use Spryker\Shared\Kernel\CodeBucket\Config\AbstractCodeBucketConfig;
use Spryker\Shared\Kernel\Store;
use Symfony\Component\HttpFoundation\Request;

class CodeBucketConfig extends AbstractCodeBucketConfig
{
    /**
     * @return array<string>
     */
    public function getCodeBuckets(): array
    {
        if ($this->isAcpDevOn()) {
            return Store::getInstance()->getAllowedStores();
        }

        return [
            'EU',
            'US',
            'DE',
            'AT',
        ];
    }

    /**
     * @deprecated This method implementation will be removed when environment configs are cleaned up.
     *
     * @return string
     */
    public function getDefaultCodeBucket(): string
    {
        if ($this->isAcpDevOn()) {
            return APPLICATION_STORE;
        }

        $codeBuckets = $this->getCodeBuckets();

        $parts = explode('/', $this->getPathInfo());
        if (isset($parts[1]) && in_array($parts[1], $codeBuckets, true)) {
            return $parts[1];
        }

        return defined('APPLICATION_REGION') ? APPLICATION_REGION : reset($codeBuckets);
    }

    /**
     * @return bool
     */
    protected function isAcpDevOn(): bool
    {
        return APPLICATION_ENV === 'docker.acp.dev';
    }

    /**
     * @return string
     */
    protected function getPathInfo(): string
    {
        $requestFromGlobals = Request::createFromGlobals();

        return $requestFromGlobals->getPathInfo();
    }
}
