<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ContactUs\Persistence;

use Orm\Zed\ContactUs\Persistence\PyzContactUs;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * Class ContactUsRepository
 *
 * @package Pyz\Zed\ContactUs\Persistence
 *
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsPersistenceFactory getFactory()
 */
class ContactUsRepository extends AbstractRepository implements ContactUsRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getContactUsMessages(): array
    {
        return $this->getFactory()->createContactUsQuery()->find()->getIterator()->getArrayCopy();
    }

    /**
     * @inheritDoc
     */
    public function findContactUsById(int $contactUsId): ?PyzContactUs
    {
        return $this->getFactory()->createContactUsQuery()->findPk($contactUsId);
    }
}
