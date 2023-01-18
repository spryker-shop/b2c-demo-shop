<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Testify\Helper;

use Codeception\Module;

class LoginHelper extends Module
{
    /**
     * @param string $username
     * @param string $password
     *
     * @return void
     */
    public function amLoggedInUser(string $username = 'admin@spryker.com', string $password = 'change123'): void
    {
        $i = $this->getClient();

        $i->amOnPage('/security-gui/login');

        $i->fillField('#auth_username', $username);
        $i->fillField('#auth_password', $password);
        $i->click('Login');
    }

    /**
     * @return \Codeception\Module|\Codeception\Lib\Framework
     */
    protected function getClient()
    {
        return $this->getModule('\\' . BootstrapHelper::class);
    }
}
