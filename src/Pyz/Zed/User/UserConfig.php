<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\User;

use Spryker\Zed\User\UserConfig as SprykerUserConfig;

class UserConfig extends SprykerUserConfig
{
    /**
     * @return array
     */
    public function getInstallerUsers()
    {
        return [
            [
                'firstName' => 'Admin',
                'lastName' => 'Spryker',
                'username' => 'admin@spryker.com',
                'password' => 'change123',
                'localeName' => 'en_US',
            ],
            [
                'firstName' => 'Admin',
                'lastName' => 'German',
                'password' => 'change123',
                'username' => 'admin_de@spryker.com',
                'localeName' => 'de_DE',
            ],
        ];
    }
}
