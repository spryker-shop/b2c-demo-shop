<?php
/**
 * Created by PhpStorm.
 * User: kravchenko
 * Date: 2019-12-06
 * Time: 11:58
 */

namespace Pyz\Zed\DataImport\Business\Model;

interface PropelExecutorInterface
{
    /**
     * @param string $sql
     * @param array $parameters
     *
     * @return array|null
     */
    public function execute(string $sql, array $parameters): ?array;
}
