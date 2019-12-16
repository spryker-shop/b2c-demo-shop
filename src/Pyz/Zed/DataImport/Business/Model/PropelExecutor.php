<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model;

use PDO;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Propel;

class PropelExecutor implements PropelExecutorInterface
{
    /**
     * @param string $sql
     * @param array $parameters
     *
     * @return array|null
     */
    public function execute(string $sql, array $parameters): ?array
    {
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return \Propel\Runtime\Connection\ConnectionInterface
     */
    protected function getConnection(): ConnectionInterface
    {
        return Propel::getConnection();
    }
}
