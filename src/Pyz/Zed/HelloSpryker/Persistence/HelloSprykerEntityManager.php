<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Persistence;

use Generated\Shared\Transfer\ContactUsTransfer;
use Orm\Zed\HelloSpryker\Persistence\PyzContactUs;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerPersistenceFactory getFactory()
 */
class HelloSprykerEntityManager extends AbstractEntityManager implements HelloSprykerEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContactUsTransfer $contactUsTransfer
     *
     * @return \Generated\Shared\Transfer\ContactUsTransfer
     */
    public function saveContactUsData(ContactUsTransfer $contactUsTransfer): ContactUsTransfer
    {
        $pyzContactUs = new PyzContactUs();
        $pyzContactUs->setName($contactUsTransfer->getName());
        $pyzContactUs->setMessage($contactUsTransfer->getMessage());
        $pyzContactUs->save();

        $contactUsTransfer->fromArray($pyzContactUs->toArray(), true);

        return $contactUsTransfer;
    }
}
