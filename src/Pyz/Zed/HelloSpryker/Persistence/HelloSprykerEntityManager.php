<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Persistence;

use Generated\Shared\Transfer\PyzContactUsEntityTransfer;
use Orm\Zed\HelloSpryker\Persistence\PyzContactUs;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerPersistenceFactory getFactory()
 */
class HelloSprykerEntityManager extends AbstractEntityManager implements HelloSprykerEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\PyzContactUsEntityTransfer $contactUsTransfer
     *
     * @return \Generated\Shared\Transfer\PyzContactUsEntityTransfer
     */
    public function saveContactUsData(PyzContactUsEntityTransfer $contactUsTransfer): PyzContactUsEntityTransfer
    {
        $pyzContactUs = new PyzContactUs();
        $pyzContactUs->setName($contactUsTransfer->getName());
        $pyzContactUs->setMessage($contactUsTransfer->getMessage());
        $pyzContactUs->save();

        /*
            *
            $pyzContactUs = $this->getFactory()
                ->createHelloSprykerQuery()
                ->filterByName($contactUsTransfer->getName())
                ->filterByMessage($contactUsTransfer->getMessage())
                ->findOneOrCreate();

            $pyzContactUs->save();
        */

        $contactUsTransfer->fromArray($pyzContactUs->toArray(), true);

        return $contactUsTransfer;
    }
}
