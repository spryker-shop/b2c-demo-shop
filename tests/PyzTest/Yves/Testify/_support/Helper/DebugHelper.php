<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Yves\Testify\Helper;

use Codeception\Module;
use Spryker\Shared\ZedRequest\ZedRequestConstants;
use SprykerTest\Shared\Testify\Helper\ConfigHelperTrait;

/**
 * This helper enables cookie forwarding to debug Zed during yves - zed requests.
 */
class DebugHelper extends Module
{
    use ConfigHelperTrait;

    /**
     * @param array $settings
     *
     * @return void
     */
    public function _beforeSuite(array $settings = []): void // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter
    {
        $_COOKIE['XDEBUG_SESSION'] = 'XDEBUG_ECLIPSE'; // phpcs:ignore SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable
        $this->getConfigHelper()->setConfig(ZedRequestConstants::TRANSFER_DEBUG_SESSION_FORWARD_ENABLED, true);
    }
}
