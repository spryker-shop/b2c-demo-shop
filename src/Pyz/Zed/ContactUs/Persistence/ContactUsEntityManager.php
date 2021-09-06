<?php


namespace Pyz\Zed\ContactUs\Persistence;


use Generated\Shared\Transfer\ContactUsTransfer;
use Orm\Zed\ContactUs\Persistence\PyzContactUs;

class ContactUsEntityManager implements ContactUsEntityManagerInterface
{
    public function saveContactUs(ContactUsTransfer $contactUsTransfer): ContactUsTransfer
    {
        $contactUsEntity = new PyzContactUs();
        $contactUsEntity->fromArray($contactUsTransfer->modifiedToArray());
        $contactUsEntity->save();

        $contactUsTransfer->fromArray($contactUsEntity->toArray(),true);

        return $contactUsTransfer;
    }
}
