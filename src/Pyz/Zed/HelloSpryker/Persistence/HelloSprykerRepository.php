<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerPersistenceFactory getFactory()
 */
class HelloSprykerRepository extends AbstractRepository implements HelloSprykerRepositoryInterface
{
    /**
     * @return \Generated\Shared\Transfer\ContactUsTransfer
     */
    public function all()
    {
        $blogQuery = $this->getFactory()
            ->createHelloSprykerQuery();

        return $this->buildQueryFromCriteria($blogQuery)
            ->find();
    }

    /**
     * @return \Generated\Shared\Transfer\ContactUsTransfer[]
     */
    public function getContactUsDataSet(): array
    {
        $contactUsQuery = $this->getFactory()
            ->createHelloSprykerQuery();

        $collection = $this->buildQueryFromCriteria($contactUsQuery)->find();

        return $collection;
    }
}
