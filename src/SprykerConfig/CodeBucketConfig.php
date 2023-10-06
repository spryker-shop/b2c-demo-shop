<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerConfig;

use Spryker\Shared\Kernel\CodeBucket\Config\AbstractCodeBucketConfig;
use Spryker\Shared\Kernel\Store;

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

        return defined('APPLICATION_REGION') ? APPLICATION_REGION : reset($codeBuckets);
    }

    /**
     * @return bool
     */
    protected function isAcpDevOn(): bool
    {
        return APPLICATION_ENV === 'docker.acp.dev';
    }
}
