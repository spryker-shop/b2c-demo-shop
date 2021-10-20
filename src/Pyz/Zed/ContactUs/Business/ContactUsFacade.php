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
     * @return mixed|void
     */
    public function getContactUsData()
    {
        return $this->getFactory()->createContactUsReader()->getContactUsEntities();
    }

    /**
     * @param ContactUsTransfer $contactUsTransfer
     *
     * @return mixed|void
     */
    public function saveContactUsData(ContactUsTransfer $contactUsTransfer)
    {
        $this->getFactory()->createContactUsWriter()->saveContactUsData($contactUsTransfer);
    }
}
