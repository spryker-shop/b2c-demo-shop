<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerPersistenceFactory getFactory()
 */
class HelloSprykerQueryContainer extends AbstractQueryContainer implements HelloSprykerQueryContainerInterface
{
    /**
     * @param $id
     *
     * @return \Orm\Zed\HelloSpryker\Persistence\PyzContactUsQuery
     */
    public function queryContactUsById($id)
    {
        return $this->getFactory()
            ->createHelloSprykerQuery()
            ->filterByIdContactUs($id);
    }

    /**
     * @api
     *
     * @return \Orm\Zed\HelloSpryker\Persistence\PyzContactUsQuery
     */
    public function queryContactUs()
    {
        return $this->getFactory()
            ->createHelloSprykerQuery();
    }
}
