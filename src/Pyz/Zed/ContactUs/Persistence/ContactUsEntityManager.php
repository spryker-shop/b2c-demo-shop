<?php

namespace Pyz\Zed\ContactUs\Persistence;

use Generated\Shared\Transfer\ContactUsTransfer;
use Orm\Zed\ContactUs\Persistence\PyzContactUs;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;


class ContactUsEntityManager extends AbstractEntityManager implements ContactUsEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContactUsTransfer $contactUsTransfer
     *
     * @return \Generated\Shared\Transfer\ContactUsTransfer
     */
    public function saveContactUsEntity(ContactUsTransfer $contactUsTransfer): ContactUsTransfer
    {
        $contactUsEntity = new PyzContactUs();
        $contactUsEntity->fromArray($contactUsTransfer->modifiedToArray());
        $contactUsEntity->save();

        $contactUsTransfer->fromArray($contactUsEntity->toArray(), true);

        return $contactUsTransfer;
    }
}
