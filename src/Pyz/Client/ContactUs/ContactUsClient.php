<?php

namespace Pyz\Client\ContactUs;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\ContactUs\ContactUsFactory getFactory()
 */
class ContactUsClient extends AbstractClient implements ContactUsClientInterface
{

    /**
     * @return \Pyz\Client\ContactUs\Zed\ContactUsStubInterface
     */
    protected function getZedStub()
    {
        return $this->getFactory()->createContactUsZedStub();
    }

    /**
     * @param ContactUsTransfer $contactUsTransfer
     *
     * @return ContactUsTransfer
     */
    public function saveContact(ContactUsTransfer $contactUsTransfer): ContactUsTransfer
    {
        return $this->getFactory()
            ->createContactUsZedStub()
            ->saveContact($contactUsTransfer);
    }
}
