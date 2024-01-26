<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\CustomerTask;

use Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class CustomerTaskWriterStep implements DataImportStepInterface
{
    /**
     * @var int
     */
    public const BULK_SIZE = 100;

    /**
     * @var string
     */
    public const KEY_CREATOR_EMAIL = 'creator_email';

    /**
     * @var string
     */
    public const KEY_FK_CREATOR = 'fk_creator';

    /**
     * @var string
     */
    public const KEY_TITLE = 'title';

    /**
     * @var string
     */
    public const KEY_DESCRIPTION = 'description';

    /**
     * @var string
     */
    public const KEY_DUE_DATE = 'due_date';

    /**
     * @var string
     */
    public const KEY_STATUS = 'status';

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $customerTaskEntity = PyzCustomerTaskQuery::create()
            ->filterByFkCreator($dataSet[self::KEY_FK_CREATOR])
            ->filterByTitle($dataSet[self::KEY_TITLE])
            ->filterByDueDate($dataSet[self::KEY_DUE_DATE])
            ->findOneOrCreate();

        $customerTaskEntity->setDescription($dataSet[self::KEY_DESCRIPTION])
            ->setStatus($dataSet[self::KEY_STATUS]);

        $customerTaskEntity->save();
    }
}
