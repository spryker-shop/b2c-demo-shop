<?php


namespace Pyz\Zed\ContactUs\Business;


use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * Class ContactUsFacade
 * @package Pyz\Zed\ContactUs\Business
 *
 * @method ContactUsBusinessFactory getFactory()
 */
class ContactUsFacade extends AbstractFacade implements ContactUsFacadeInterface
{
    public function getContactUsMessages(): array
    {
        return $this->getFactory()->createReader()->getContactUsMessages();
    }

    public function findContactUsById(int $contactUsId): ?ContactUsTransfer
    {
        return $this->getFactory()->createReader()->findContactUsById($contactUsId);
    }

    public function saveContactUs(ContactUsTransfer $contactUsTransfer): ContactUsTransfer
    {
        return $this->getFactory()->createWriter()->saveContactUs($contactUsTransfer);
    }
}
