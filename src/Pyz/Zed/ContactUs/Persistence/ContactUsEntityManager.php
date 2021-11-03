<?php

namespace Pyz\Zed\ContactUs\Persistence;

use Generated\Shared\Transfer\ContactUsTransfer;
use Orm\Zed\ContactUs\Persistence\PyzContactUs;

use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;


class ContactUsEntityManager extends AbstractEntityManager implements ContactUsEntityManagerInterface
{
    /**
     * @param ContactUsTransfer $contactUsTransfer
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function saveContactUsEntity(ContactUsTransfer $contactUsTransfer): bool
    {
        $contactUsEntity = new PyzContactUs();
        $contactUsEntity->fromArray($contactUsTransfer->modifiedToArray());

        return (bool) $contactUsEntity->save();
    }
}
