<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Business\Exception;

use Exception;

class CustomerTaskNotFoundException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(string $message = '', int $code = 0, ?Exception $previous = null)
    {
        $message .= 'Customer task not found.';

        parent::__construct($message, $code, $previous);
    }
}
