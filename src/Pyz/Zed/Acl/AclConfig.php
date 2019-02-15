<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Acl;

use Spryker\Shared\Acl\AclConstants;
use Spryker\Zed\Acl\AclConfig as SprykerAclConfig;

class AclConfig extends SprykerAclConfig
{
    /**
     * @return array
     */
    public function getInstallerUsers()
    {
        return [
            'admin@spryker.com' => [
                'group' => AclConstants::ROOT_GROUP,
            ],
            'admin_de@spryker.com' => [
                'group' => AclConstants::ROOT_GROUP,
            ],
            //this is related to existent username and will be searched into the database
        ];
    }
}
