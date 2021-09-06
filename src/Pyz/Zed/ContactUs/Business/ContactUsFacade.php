<?php

namespace Pyz\Zed\ContactUs\Business;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\ContactUs\Business\ContactUsBusinessFactory getFactory()
 */
class ContactUsFacade extends AbstractFacade implements ContactUsFacadeInterface
{
    /**
     * @param ContactUsTransfer $contactTransfer
     *
     * @return ContactUsTransfer|null
     */
    public function getContactUsData(ContactUsTransfer $contactTransfer)
    {
        return $this->getFactory()
            ->createContactReader()
            ->getContact($contactTransfer);
    }

    /**
     * @param ContactUsTransfer $contactTransfer
     *
     * @return ContactUsTransfer
     */
    public function saveContactUsData(ContactUsTransfer $contactTransfer): ContactUsTransfer
    {
        return $this->getFactory()->createContactUsWriter()->saveContact($contactTransfer);
    }
}
